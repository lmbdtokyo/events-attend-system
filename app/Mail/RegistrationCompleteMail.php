<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationCompleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $eventuser;
    public $event;
    public $password;
    public $eventFinishMail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($eventuser, $event , $password,$eventFinishMail)
    {
        $this->eventuser = $eventuser;
        $this->event = $event;
        $this->password = $password;
        $this->eventFinishMail = $eventFinishMail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->eventFinishMail->title)
                    ->view('emails.registration_complete')
                    ->bcc(explode(',', $this->eventFinishMail->bcc));
    }
}
