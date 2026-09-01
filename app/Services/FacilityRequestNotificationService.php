<?php

namespace App\Services;

use App\Models\FacilityRequest;
use App\Models\DeptAccount;
use App\Notifications\NewFacilityRequestNotification;
use App\Events\FacilityRequestNotificationCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FacilityRequestNotificationService
{
    /**
     * Process events from core1events API and create notifications
     * 
     * @param array $events Array of events from core1events API
     * @return array Statistics about processed events
     */
    public function processEvents(array $events): array
    {
        $stats = [
            'processed' => 0,
            'notifications_created' => 0,
            'skipped' => 0,
            'errors' => 0,
        ];

        foreach ($events as $event) {
            try {
                // Extract event booking ID - adjust field names based on actual API response
                // The API uses eventbookingID (camelCase)
                $eventBookingId = $event['eventbookingID'] ?? $event['eventBookingID'] ?? $event['id'] ?? $event['booking_id'] ?? $event['bookingId'] ?? null;
                
                if (!$eventBookingId) {
                    Log::debug('Skipping event - no booking ID found', [
                        'event_keys' => array_keys($event),
                        'event_sample' => json_encode(array_slice($event, 0, 3)),
                    ]);
                    $stats['skipped']++;
                    continue;
                }
                
                Log::debug('Processing event', [
                    'event_booking_id' => $eventBookingId,
                    'event_status' => $event['eventstatus'] ?? $event['status'] ?? 'unknown',
                ]);

                // Check if we've already processed this event (deduplication)
                $dedupeKey = "facility_request_notification:{$eventBookingId}";
                if (Cache::has($dedupeKey)) {
                    $stats['skipped']++;
                    continue;
                }

                // Try to find or create FacilityRequest from event data
                $facilityRequest = $this->findOrCreateFacilityRequest($event);
                
                if (!$facilityRequest) {
                    $stats['skipped']++;
                    continue;
                }

                // Only create notification for new/pending requests
                if ($facilityRequest->status !== 'pending') {
                    $stats['skipped']++;
                    continue;
                }

                // Get admin users who should receive notifications
                $adminUsers = $this->getAdminUsers();

                Log::info('Processing notification for facility request', [
                    'request_id' => $facilityRequest->id,
                    'admin_users_count' => $adminUsers->count(),
                ]);

                foreach ($adminUsers as $admin) {
                    // Check if notification already exists for this user and request
                    $existingNotification = $admin->notifications()
                        ->where('type', NewFacilityRequestNotification::class)
                        ->where('data->request_id', $facilityRequest->id)
                        ->whereNull('read_at')
                        ->first();

                    if ($existingNotification) {
                        Log::debug('Notification already exists for user', [
                            'user_id' => $admin->id,
                            'request_id' => $facilityRequest->id,
                        ]);
                        continue; // Skip if already notified
                    }

                    // Create notification
                    try {
                        $notification = $admin->notify(new NewFacilityRequestNotification($facilityRequest, $event));
                        
                        // Get the created notification
                        $createdNotification = $admin->notifications()
                            ->where('type', NewFacilityRequestNotification::class)
                            ->where('data->request_id', $facilityRequest->id)
                            ->latest()
                            ->first();
                        
                        if ($createdNotification) {
                            // Broadcast event for real-time update
                            event(new FacilityRequestNotificationCreated(
                                $createdNotification,
                                $admin
                            ));
                            
                            Log::info('Notification created and broadcast', [
                                'user_id' => $admin->id,
                                'notification_id' => $createdNotification->id,
                                'request_id' => $facilityRequest->id,
                            ]);
                        }
                    } catch (\Exception $e) {
                        Log::error('Error creating notification', [
                            'user_id' => $admin->id,
                            'request_id' => $facilityRequest->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }

                // Mark event as processed (cache for 24 hours)
                Cache::put($dedupeKey, true, now()->addHours(24));
                
                $stats['processed']++;
                $stats['notifications_created'] += count($adminUsers);

            } catch (\Exception $e) {
                Log::error('Error processing facility request event', [
                    'event' => $event,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $stats['errors']++;
            }
        }

        return $stats;
    }

    /**
     * Find or create FacilityRequest from event data
     */
    private function findOrCreateFacilityRequest(array $event): ?FacilityRequest
    {
        try {
            // Extract event booking ID
            $eventBookingId = $event['eventbookingID'] ?? $event['id'] ?? $event['booking_id'] ?? null;
            
            if (!$eventBookingId) {
                return null;
            }

            // Try to find existing request by matching event data
            // You may need to adjust these field mappings based on actual API response
            $facilityRequest = FacilityRequest::where('notes->event_booking_id', $eventBookingId)
                ->orWhere(function($query) use ($event) {
                    // Try matching by facility, datetime, and contact info
                    if (isset($event['facility_id']) && isset($event['requested_datetime'])) {
                        $query->where('facility_id', $event['facility_id'])
                              ->where('requested_datetime', $event['requested_datetime']);
                    }
                })
                ->first();

            if ($facilityRequest) {
                return $facilityRequest;
            }

            // If not found, create a new FacilityRequest from event data
            // Adjust field mappings based on actual API response structure
            $requestData = [
                'request_type' => $event['request_type'] ?? 'reservation',
                'department' => $event['department'] ?? 'General',
                'priority' => $event['priority'] ?? 'medium',
                'location' => $event['location'] ?? 'N/A',
                'facility_id' => $event['facility_id'] ?? null,
                'requested_datetime' => $event['requested_datetime'] ?? $event['start_time'] ?? now(),
                'requested_end_datetime' => $event['requested_end_datetime'] ?? $event['end_time'] ?? null,
                'description' => $event['description'] ?? $event['purpose'] ?? 'Facility request from external system',
                'contact_name' => $event['contact_name'] ?? $event['requester_name'] ?? 'Unknown',
                'contact_email' => $event['contact_email'] ?? $event['requester_email'] ?? 'unknown@example.com',
                'status' => 'pending',
                'notes' => [
                    'event_booking_id' => $eventBookingId,
                    'source' => 'core1events',
                    'event_data' => $event,
                ],
            ];

            $facilityRequest = FacilityRequest::create($requestData);
            
            Log::info('Created FacilityRequest from core1events', [
                'request_id' => $facilityRequest->id,
                'event_booking_id' => $eventBookingId,
            ]);

            return $facilityRequest;

        } catch (\Exception $e) {
            Log::error('Error finding/creating FacilityRequest from event', [
                'event' => $event,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Get admin department accounts who should receive facility request notifications
     */
    private function getAdminUsers(): \Illuminate\Database\Eloquent\Collection
    {
        // Get department accounts with admin roles and active status
        $accounts = collect();
        
        // Query department_accounts table for admin roles
        $adminRoles = ['Administrator', 'Super Admin', 'Admin', 'SuperAdmin'];
        
        $accounts = DeptAccount::where(function($query) use ($adminRoles) {
            $query->whereIn('role', $adminRoles)
                  ->orWhere('role', 'like', '%Administrator%')
                  ->orWhere('role', 'like', '%Super Admin%')
                  ->orWhere('role', 'like', '%Admin%');
        })
        ->where('status', 'active') // Only active accounts
        ->get();
        
        Log::debug('Admin department accounts found by role', [
            'count' => $accounts->count(),
            'roles_searched' => $adminRoles,
        ]);
        
        // Fallback: if no admin accounts found, try to get all active accounts
        if ($accounts->isEmpty()) {
            Log::warning('No admin department accounts found. Trying all active accounts as fallback.');
            $allAccounts = DeptAccount::where('status', 'active')->get();
            
            if ($allAccounts->isEmpty()) {
                Log::error('No active department accounts found in database! Notifications cannot be sent.');
                return DeptAccount::whereRaw('1 = 0')->get(); // Return empty Eloquent collection
            }
            
            Log::info('Fallback: Using all active department accounts', [
                'total_accounts' => $allAccounts->count(),
                'account_emails' => $allAccounts->pluck('email')->filter()->toArray(),
            ]);
            return $allAccounts;
        }
        
        Log::info('Admin department accounts selected for notifications', [
            'count' => $accounts->count(),
            'account_ids' => $accounts->pluck('Dept_no')->toArray(),
            'account_emails' => $accounts->pluck('email')->filter()->toArray(),
            'account_names' => $accounts->pluck('employee_name')->toArray(),
        ]);
        
        return $accounts;
    }
}
