<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Mail\OtpCodeMail;

class OtpCodeNotification extends Notification
{
    protected $otpCode;
    protected $employeeName;

    public function __construct($otpCode, $employeeName)
    {
        $this->otpCode = $otpCode;
        $this->employeeName = $employeeName;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Use Mailable class instead of MailMessage to avoid DOMDocument issues
        return new OtpCodeMail($this->otpCode, $this->employeeName);
    }
}
