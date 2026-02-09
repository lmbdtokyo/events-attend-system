<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApprovalStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $eventUser;
    protected $event;

    /**
     * Create a new message instance.
     */
    public function __construct($eventUser, $event)
    {
        $this->eventUser = $eventUser;
        $this->event = $event;
    }

    public function build()
    {
        $eventName = $this->event->name;
        $subject = $this->eventUser->approval == 1 
            ? '【' . $eventName . '】アカウント承認のお知らせ' 
            : '【' . $eventName . '】アカウント承認について';
        
        return $this->view('emails.approval_status_changed')
                    ->subject($subject)
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->replyTo(config('mail.from.address'), config('mail.from.name'))
                    ->with([
                        'eventUser' => $this->eventUser,
                        'event' => $this->event
                    ]);
    }
}
