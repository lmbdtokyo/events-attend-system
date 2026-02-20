<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventuserPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $eventuser;
    public $event;
    public $resetUrl;

    public function __construct($eventuser, $event, $token)
    {
        $this->eventuser = $eventuser;
        $this->event = $event;
        $this->resetUrl = url('/events/' . $event->id . '/password/reset/' . $token);
    }

    public function build()
    {
        return $this->subject('[' . $this->event->name . '] パスワード再設定のご案内')
                    ->view('emails.eventuser_password_reset');
    }
}
