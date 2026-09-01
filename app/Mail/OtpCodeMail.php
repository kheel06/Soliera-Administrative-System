<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpCodeMail extends Mailable
{
    use SerializesModels;

    public $otpCode;
    public $employeeName;

    public function __construct($otpCode, $employeeName)
    {
        $this->otpCode = !empty($otpCode) ? $otpCode : '000000';
        $this->employeeName = !empty($employeeName) ? $employeeName : 'User';
    }

    public function build()
    {
        return $this->subject('🔐 Your OTP Code - Soliera Hotel Login')
                    ->view('emails.otp-code')
                    ->with([
                        'otpCode' => $this->otpCode,
                        'employeeName' => $this->employeeName
                    ]);
    }
}
