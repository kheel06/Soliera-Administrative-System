<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Services\FacilityRequestNotificationService;
use App\Http\Controllers\SolieraApiProxyController;

class IngestCore1Events implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [60, 300, 900]; // 1 min, 5 min, 15 min

    /**
     * Execute the job.
     */
    public function handle(FacilityRequestNotificationService $notificationService): void
    {
        try {
            $baseUrl = config('services.soliera.base_url', 'https://hotel.soliera-hotel-restaurant.com');
            $url = rtrim($baseUrl, '/') . '/api/core1events';
            
            // Get last seen event timestamp for incremental polling
            $lastSeenKey = 'core1events:last_seen_timestamp';
            $lastSeen = Cache::get($lastSeenKey);
            
            // Build request with optional since parameter if available
            $params = [];
            if ($lastSeen) {
                $params['since'] = $lastSeen;
            }

            // Get API token
            $token = config('services.soliera.token') ?? config('services.soliera_hotel_api.token');
            
            $response = Http::timeout(30)
                ->retry(3, 1000)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ])
                ->get($url, $params);

            if (!$response->successful()) {
                Log::warning('Failed to fetch core1events', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return;
            }

            $data = $response->json();
            
            // Normalize response format (same as SolieraApiProxyController)
            $events = [];
            if (is_array($data)) {
                if (array_is_list($data)) {
                    $events = $data;
                } elseif (isset($data['data']) && is_array($data['data'])) {
                    $events = $data['data'];
                } elseif (isset($data['events']) && is_array($data['events'])) {
                    $events = $data['events'];
                }
            }

            if (empty($events)) {
                Log::debug('No events found in core1events response');
                return;
            }

            // Process events and create notifications
            $stats = $notificationService->processEvents($events);

            // Update last seen timestamp
            $latestTimestamp = $this->getLatestEventTimestamp($events);
            if ($latestTimestamp) {
                Cache::put($lastSeenKey, $latestTimestamp, now()->addDays(7));
            }

            Log::info('Ingested core1events', [
                'events_count' => count($events),
                'stats' => $stats,
            ]);

        } catch (\Exception $e) {
            Log::error('Error ingesting core1events', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e; // Re-throw to trigger retry
        }
    }

    /**
     * Get the latest event timestamp from events array
     */
    private function getLatestEventTimestamp(array $events): ?string
    {
        $latest = null;
        foreach ($events as $event) {
            $timestamp = $event['created_at'] ?? $event['timestamp'] ?? $event['requested_datetime'] ?? null;
            if ($timestamp && (!$latest || $timestamp > $latest)) {
                $latest = $timestamp;
            }
        }
        return $latest;
    }
}
