<?php

namespace App\Services\Microservices;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FacilityService extends AbstractMicroservice
{
    protected string $serviceName = 'facility';

    /**
     * Get all facilities
     */
    public function getFacilities(array $filters = []): array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($filters) {
                $response = $this->get('/facilities', $filters);
                $this->logCommunication('get_facilities', $filters, $response);
                return $response;
            },
            "facilities_" . md5(json_encode($filters)),
            600 // Cache for 10 minutes
        );
    }

    /**
     * Get facility by ID
     */
    public function getFacility(int $facilityId): ?array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($facilityId) {
                $response = $this->get("/facilities/{$facilityId}");
                $this->logCommunication('get_facility', ['id' => $facilityId], $response);
                return $response;
            },
            "facility_{$facilityId}",
            1800 // Cache for 30 minutes
        );
    }

    /**
     * Create facility reservation
     */
    public function createReservation(array $reservationData): array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($reservationData) {
                $response = $this->post('/reservations', $reservationData);
                $this->logCommunication('create_reservation', $reservationData, $response);
                return $response;
            },
            "reservation_create_" . md5(json_encode($reservationData))
        );
    }

    /**
     * Get reservation by ID
     */
    public function getReservation(int $reservationId): ?array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($reservationId) {
                $response = $this->get("/reservations/{$reservationId}");
                $this->logCommunication('get_reservation', ['id' => $reservationId], $response);
                return $response;
            },
            "reservation_{$reservationId}",
            600 // Cache for 10 minutes
        );
    }

    /**
     * Update reservation
     */
    public function updateReservation(int $reservationId, array $updateData): array
    {
        $response = $this->put("/reservations/{$reservationId}", $updateData);
        $this->logCommunication('update_reservation', ['id' => $reservationId, 'data' => $updateData], $response);
        
        // Clear cache
        Cache::forget("reservation_{$reservationId}");
        
        return $response;
    }

    /**
     * Cancel reservation
     */
    public function cancelReservation(int $reservationId, array $cancelData = []): array
    {
        $response = $this->post("/reservations/{$reservationId}/cancel", $cancelData);
        $this->logCommunication('cancel_reservation', ['id' => $reservationId], $response);
        
        // Clear cache
        Cache::forget("reservation_{$reservationId}");
        
        return $response;
    }

    /**
     * Get facility availability
     */
    public function getFacilityAvailability(int $facilityId, string $startDate, string $endDate): array
    {
        return $this->get("/facilities/{$facilityId}/availability", [
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    /**
     * Search reservations
     */
    public function searchReservations(array $filters = [], int $page = 1, int $limit = 20): array
    {
        $params = array_merge($filters, ['page' => $page, 'limit' => $limit]);
        
        return $this->executeWithCircuitBreaker(
            function () use ($params) {
                $response = $this->get('/reservations/search', $params);
                $this->logCommunication('search_reservations', $params, $response);
                return $response;
            },
            "reservation_search_" . md5(json_encode($params)),
            300 // Cache for 5 minutes
        );
    }

    /**
     * Get facility calendar
     */
    public function getFacilityCalendar(int $facilityId, string $month, string $year): array
    {
        return $this->get("/facilities/{$facilityId}/calendar", [
            'month' => $month,
            'year' => $year
        ]);
    }

    /**
     * Approve reservation
     */
    public function approveReservation(int $reservationId, array $approvalData = []): array
    {
        return $this->post("/reservations/{$reservationId}/approve", $approvalData);
    }

    /**
     * Reject reservation
     */
    public function rejectReservation(int $reservationId, array $rejectionData): array
    {
        return $this->post("/reservations/{$reservationId}/reject", $rejectionData);
    }

    /**
     * Get reservation statistics
     */
    public function getReservationStats(array $filters = []): array
    {
        return $this->get('/reservations/stats', $filters);
    }

    /**
     * Get facility usage report
     */
    public function getFacilityUsageReport(int $facilityId, array $dateRange): array
    {
        return $this->get("/facilities/{$facilityId}/usage-report", $dateRange);
    }

    /**
     * Create facility
     */
    public function createFacility(array $facilityData): array
    {
        return $this->post('/facilities', $facilityData);
    }

    /**
     * Update facility
     */
    public function updateFacility(int $facilityId, array $updateData): array
    {
        $response = $this->put("/facilities/{$facilityId}", $updateData);
        
        // Clear cache
        Cache::forget("facility_{$facilityId}");
        
        return $response;
    }

    /**
     * Delete facility
     */
    public function deleteFacility(int $facilityId): bool
    {
        $response = $this->delete("/facilities/{$facilityId}");
        
        // Clear cache
        Cache::forget("facility_{$facilityId}");
        
        return $response['success'] ?? false;
    }

    /**
     * Get upcoming reservations
     */
    public function getUpcomingReservations(int $facilityId = null, int $days = 7): array
    {
        $params = ['days' => $days];
        if ($facilityId) {
            $params['facility_id'] = $facilityId;
        }
        
        return $this->get('/reservations/upcoming', $params);
    }

    /**
     * Get reservation conflicts
     */
    public function checkReservationConflicts(array $reservationData): array
    {
        return $this->post('/reservations/check-conflicts', $reservationData);
    }

    /**
     * Bulk reservation operations
     */
    public function bulkUpdateReservations(array $reservationIds, array $updateData): array
    {
        return $this->post('/reservations/bulk-update', [
            'reservation_ids' => $reservationIds,
            'update_data' => $updateData
        ]);
    }

    /**
     * Get facility maintenance schedule
     */
    public function getMaintenanceSchedule(int $facilityId): array
    {
        return $this->get("/facilities/{$facilityId}/maintenance");
    }

    /**
     * Schedule maintenance
     */
    public function scheduleMaintenance(int $facilityId, array $maintenanceData): array
    {
        return $this->post("/facilities/{$facilityId}/maintenance", $maintenanceData);
    }
}
