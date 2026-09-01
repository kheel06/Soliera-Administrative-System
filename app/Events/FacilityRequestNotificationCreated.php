<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\DeptAccount;

class FacilityRequestNotificationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $account;

    public function __construct($notification, DeptAccount $account)
    {
        $this->notification = $notification;
        $this->account = $account;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->account->Dept_no);
    }

    public function broadcastAs()
    {
        return 'notification.created';
    }

    public function broadcastWith()
    {
        return [
            'action' => 'NEW_NOTIFICATION',
            'notification' => $this->notification,
            'unread_count' => $this->account->unreadNotifications()->count(),
        ];
    }
}
