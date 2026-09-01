<?php

namespace App\Services\Microservices;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NotificationService extends AbstractMicroservice
{
    protected string $serviceName = 'notification';

    /**
     * Send notification
     */
    public function sendNotification(array $notificationData): array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($notificationData) {
                $response = $this->post('/notifications', $notificationData);
                $this->logCommunication('send_notification', $notificationData, $response);
                return $response;
            },
            "notification_" . md5(json_encode($notificationData))
        );
    }

    /**
     * Send email notification
     */
    public function sendEmail(array $emailData): array
    {
        return $this->post('/notifications/email', $emailData);
    }

    /**
     * Send SMS notification
     */
    public function sendSms(array $smsData): array
    {
        return $this->post('/notifications/sms', $smsData);
    }

    /**
     * Send push notification
     */
    public function sendPushNotification(array $pushData): array
    {
        return $this->post('/notifications/push', $pushData);
    }

    /**
     * Get user notifications
     */
    public function getUserNotifications(int $userId, array $filters = []): array
    {
        return $this->get("/notifications/user/{$userId}", $filters);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId): array
    {
        return $this->put("/notifications/{$notificationId}/read");
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(int $notificationId): array
    {
        return $this->put("/notifications/{$notificationId}/unread");
    }

    /**
     * Delete notification
     */
    public function deleteNotification(int $notificationId): bool
    {
        $response = $this->delete("/notifications/{$notificationId}");
        return $response['success'] ?? false;
    }

    /**
     * Get notification templates
     */
    public function getNotificationTemplates(array $filters = []): array
    {
        return $this->get('/notifications/templates', $filters);
    }

    /**
     * Create notification template
     */
    public function createTemplate(array $templateData): array
    {
        return $this->post('/notifications/templates', $templateData);
    }

    /**
     * Update notification template
     */
    public function updateTemplate(int $templateId, array $updateData): array
    {
        return $this->put("/notifications/templates/{$templateId}", $updateData);
    }

    /**
     * Send bulk notifications
     */
    public function sendBulkNotifications(array $notificationData): array
    {
        return $this->post('/notifications/bulk', $notificationData);
    }

    /**
     * Get notification statistics
     */
    public function getNotificationStats(array $filters = []): array
    {
        return $this->get('/notifications/stats', $filters);
    }

    /**
     * Schedule notification
     */
    public function scheduleNotification(array $notificationData): array
    {
        return $this->post('/notifications/schedule', $notificationData);
    }

    /**
     * Cancel scheduled notification
     */
    public function cancelScheduledNotification(int $scheduleId): array
    {
        return $this->delete("/notifications/schedule/{$scheduleId}");
    }

    /**
     * Get scheduled notifications
     */
    public function getScheduledNotifications(array $filters = []): array
    {
        return $this->get('/notifications/scheduled', $filters);
    }

    /**
     * Send notification to department
     */
    public function sendToDepartment(string $department, array $notificationData): array
    {
        return $this->post("/notifications/department/{$department}", $notificationData);
    }

    /**
     * Send notification to role
     */
    public function sendToRole(string $role, array $notificationData): array
    {
        return $this->post("/notifications/role/{$role}", $notificationData);
    }

    /**
     * Get notification preferences
     */
    public function getNotificationPreferences(int $userId): array
    {
        return $this->get("/notifications/preferences/{$userId}");
    }

    /**
     * Update notification preferences
     */
    public function updateNotificationPreferences(int $userId, array $preferences): array
    {
        return $this->put("/notifications/preferences/{$userId}", $preferences);
    }

    /**
     * Get notification delivery logs
     */
    public function getDeliveryLogs(array $filters = []): array
    {
        return $this->get('/notifications/delivery-logs', $filters);
    }

    /**
     * Retry failed notification
     */
    public function retryNotification(int $notificationId): array
    {
        return $this->post("/notifications/{$notificationId}/retry");
    }

    /**
     * Send system alert
     */
    public function sendSystemAlert(array $alertData): array
    {
        return $this->post('/notifications/system-alert', $alertData);
    }

    /**
     * Get unread count for user
     */
    public function getUnreadCount(int $userId): array
    {
        return $this->get("/notifications/user/{$userId}/unread-count");
    }

    /**
     * Mark all notifications as read for user
     */
    public function markAllAsRead(int $userId): array
    {
        return $this->put("/notifications/user/{$userId}/read-all");
    }
}
