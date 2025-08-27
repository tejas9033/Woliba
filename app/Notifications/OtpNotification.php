<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OtpNotification extends Notification
{
    use Queueable;

    protected $otp, $firstName;

    public function __construct(string $otp, string $firstName)
    {
        $this->otp = $otp;
        $this->firstName = $firstName;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->view('emails.otp', [
                'firstName' => $this->firstName,
                'otp' => $this->otp,
            ]);
    }
}
