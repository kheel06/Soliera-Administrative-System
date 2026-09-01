<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notificationId;
    public $action;
    public $account;
    protected $channelUserId;

    public function __construct($notificationId, string $action, $account)
    {
        $this->notificationId = $notificationId;
        $this->action = $action; // 'read', 'cleared', 'handled'
        $this->account = $account;

        // Support both DeptAccount and User models
        $this->channelUserId = $account->Dept_no ?? $account->id ?? null;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->channelUserId);
    }

    public function broadcastAs()
    {
        return 'notification.updated';
    }

    public function broadcastWith()
    {
        return [
            'action' => $this->action,
            'notification_id' => $this->notificationId,
            'unread_count' => $this->account->unreadNotifications()->count(),
        ];
    }
}
