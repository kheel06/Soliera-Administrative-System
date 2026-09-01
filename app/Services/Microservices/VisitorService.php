<?php

namespace App\Services\Microservices;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class VisitorService extends AbstractMicroservice
{
    protected string $serviceName = 'visitor';

    /**
     * Register new visitor
     */
    public function registerVisitor(array $visitorData): array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($visitorData) {
                $response = $this->post('/visitors', $visitorData);
                $this->logCommunication('register_visitor', $visitorData, $response);
                return $response;
            },
            "visitor_register_" . md5(json_encode($visitorData))
        );
    }

    /**
     * Check in visitor
     */
    public function checkInVisitor(int $visitorId, array $checkInData): array
    {
        $response = $this->post("/visitors/{$visitorId}/check-in", $checkInData);
        $this->logCommunication('check_in_visitor', ['id' => $visitorId, 'data' => $checkInData], $response);
        return $response;
    }

    /**
     * Check out visitor
     */
    public function checkOutVisitor(int $visitorId, array $checkOutData = []): array
    {
        $response = $this->post("/visitors/{$visitorId}/check-out", $checkOutData);
        $this->logCommunication('check_out_visitor', ['id' => $visitorId], $response);
        return $response;
    }

    /**
     * Get visitor by ID
     */
    public function getVisitor(int $visitorId): ?array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($visitorId) {
                $response = $this->get("/visitors/{$visitorId}");
                $this->logCommunication('get_visitor', ['id' => $visitorId], $response);
                return $response;
            },
            "visitor_{$visitorId}",
            1800 // Cache for 30 minutes
        );
    }

    /**
     * Search visitors
     */
    public function searchVisitors(array $filters = [], int $page = 1, int $limit = 20): array
    {
        $params = array_merge($filters, ['page' => $page, 'limit' => $limit]);
        
        return $this->executeWithCircuitBreaker(
            function () use ($params) {
                $response = $this->get('/visitors/search', $params);
                $this->logCommunication('search_visitors', $params, $response);
                return $response;
            },
            "visitor_search_" . md5(json_encode($params)),
            300 // Cache for 5 minutes
        );
    }

    /**
     * Get active visitors
     */
    public function getActiveVisitors(): array
    {
        return $this->get('/visitors/active');
    }

    /**
     * Get visitor logs
     */
    public function getVisitorLogs(array $filters = []): array
    {
        return $this->get('/visitors/logs', $filters);
    }

    /**
     * Generate QR pass for visitor
     */
    public function generateQrPass(int $visitorId, array $options = []): array
    {
        return $this->post("/visitors/{$visitorId}/qr-pass", $options);
    }

    /**
     * Validate QR pass
     */
    public function validateQrPass(string $qrCode): array
    {
        return $this->post('/visitors/validate-qr', ['qr_code' => $qrCode]);
    }

    /**
     * Report visitor violation
     */
    public function reportViolation(int $visitorId, array $violationData): array
    {
        return $this->post("/visitors/{$visitorId}/violations", $violationData);
    }

    /**
     * Get visitor violations
     */
    public function getVisitorViolations(int $visitorId): array
    {
        return $this->get("/visitors/{$visitorId}/violations");
    }

    /**
     * Bulk visitor registration
     */
    public function bulkRegisterVisitors(array $visitorsData): array
    {
        return $this->post('/visitors/bulk-register', ['visitors' => $visitorsData]);
    }

    /**
     * Get visitor statistics
     */
    public function getVisitorStats(array $filters = []): array
    {
        return $this->get('/visitors/stats', $filters);
    }

    /**
     * Pre-register visitor
     */
    public function preRegisterVisitor(array $visitorData): array
    {
        return $this->post('/visitors/pre-register', $visitorData);
    }

    /**
     * Update visitor information
     */
    public function updateVisitor(int $visitorId, array $updateData): array
    {
        $response = $this->put("/visitors/{$visitorId}", $updateData);
        $this->logCommunication('update_visitor', ['id' => $visitorId, 'data' => $updateData], $response);
        
        // Clear cache
        Cache::forget("visitor_{$visitorId}");
        
        return $response;
    }

    /**
     * Get visitor access history
     */
    public function getVisitorAccessHistory(int $visitorId, array $filters = []): array
    {
        return $this->get("/visitors/{$visitorId}/access-history", $filters);
    }

    /**
     * Blacklist visitor
     */
    public function blacklistVisitor(int $visitorId, array $reasonData): array
    {
        return $this->post("/visitors/{$visitorId}/blacklist", $reasonData);
    }

    /**
     * Get blacklisted visitors
     */
    public function getBlacklistedVisitors(): array
    {
        return $this->get('/visitors/blacklisted');
    }

    /**
     * Send visitor notification
     */
    public function sendNotification(int $visitorId, array $notificationData): array
    {
        return $this->post("/visitors/{$visitorId}/notify", $notificationData);
    }
}
