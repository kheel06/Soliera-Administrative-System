<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Facades\Log;

class SystemActionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->data['title'] ?? 'System Notification')
            ->line($this->data['message'] ?? 'A system action has occurred.')
            ->action('View Details', url('/'));
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->data['title'] ?? 'System Notification',
            'message' => $this->data['message'] ?? 'A system action has occurred.',
            'type' => $this->data['type'] ?? 'info',
            'severity' => $this->data['severity'] ?? $this->data['type'] ?? 'info',
            'category' => $this->data['category'] ?? $this->data['model_type'] ?? 'general',
            'icon' => $this->data['icon'] ?? $this->getIconForCategory($this->data['category'] ?? $this->data['model_type'] ?? 'general'),
            'action' => $this->data['action'] ?? null,
            'model_type' => $this->data['model_type'] ?? null,
            'model_id' => $this->data['model_id'] ?? null,
            'url' => $this->data['url'] ?? $this->generateDeepLink(),
        ];
    }

    /**
     * Get default icon based on category
     */
    protected function getIconForCategory($category)
    {
        $icons = [
            'visitor' => 'user-check',
            'document' => 'file-text',
            'contract' => 'file-signature',
            'approval' => 'check-circle',
            'permit' => 'shield-check',
            'legal' => 'balance-scale',
            'risk' => 'alert-triangle',
            'facility' => 'building',
            'system' => 'settings',
        ];

        return $icons[$category] ?? 'bell';
    }

    /**
     * Generate default deep link if not provided
     */
    protected function generateDeepLink()
    {
        $type = $this->data['model_type'] ?? '';
        $id = $this->data['model_id'] ?? '';

        if (!$type || !$id)
            return '#';

        switch ($type) {
            case 'contract':
                return route('legal.contracts.details', $id);
            case 'document':
                return route('document.show', $id);
            case 'visitor':
                return route('visitors.badges');
            case 'legal_case':
                return route('legal.cases.show', $id);
            case 'facility_reservation':
                return route('facilities.reservations.details', $id);
            case 'permit':
                return route('compliance.permits.show', $id);
            case 'ai_analysis':
                return route('legal.ai.show', $id);
            case 'template':
                return route('legal.templates'); // Index since we don't have a show yet
            case 'clause':
                return route('legal.templates'); // Index
            case 'approval':
                return route('executive.approvals.index');
            default:
                return '#';
        }
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return $this->toArray($notifiable);
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'notification' => [
                'id' => $this->id,
                'data' => $this->toArray($notifiable),
                'created_at' => now()->toIso8601ZuluString(),
            ],
            'unread_count' => $notifiable->unreadNotifications()->count() + 1, // +1 because it's not in DB yet during broadcast usually
        ]);
    }

    /**
     * Get the type of the notification being broadcast.
     */
    public function broadcastType()
    {
        return 'notification.created';
    }
}

