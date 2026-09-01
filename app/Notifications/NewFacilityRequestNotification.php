<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\FacilityRequest;

class NewFacilityRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $facilityRequest;
    public $eventData;

    public function __construct(FacilityRequest $facilityRequest, array $eventData = [])
    {
        $this->facilityRequest = $facilityRequest;
        $this->eventData = $eventData;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        $facilityName = $this->facilityRequest->facility->name ?? 'Unknown Facility';
        $requestType = ucfirst(str_replace('_', ' ', $this->facilityRequest->request_type));
        
        return [
            'type' => 'NEW_FACILITY_REQUEST',
            'title' => "New {$requestType} Request",
            'message' => "New {$requestType} request for {$facilityName} from {$this->facilityRequest->contact_name}",
            'request_id' => $this->facilityRequest->id,
            'facility_id' => $this->facilityRequest->facility_id,
            'facility_name' => $facilityName,
            'requester_name' => $this->facilityRequest->contact_name,
            'requester_email' => $this->facilityRequest->contact_email,
            'request_type' => $this->facilityRequest->request_type,
            'priority' => $this->facilityRequest->priority,
            'status' => $this->facilityRequest->status,
            'url' => route('facility_reservations.new_request', ['tab' => $this->facilityRequest->request_type]) . '#request-' . $this->facilityRequest->id,
            'created_at' => $this->facilityRequest->created_at->toIso8601String(),
            'icon' => 'bell',
            'badge' => '<span class="badge badge-xs badge-warning">New</span>',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'id' => $this->id,
            'type' => get_class($this),
            'data' => $this->toArray($notifiable),
            'read_at' => null,
            'created_at' => now()->toIso8601String(),
        ];
    }
}
