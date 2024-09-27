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

    /**
     * Create a new message instance.
     */
    public function __construct($eventUser)
    {
        $this->eventUser = $eventUser;
    }

    public function build()
    {
        $subject = $this->eventUser->approval == 1 ? 'アカウントが承認されました' : 'アカウントが承認されませんでした';
        return $this->view('emails.approval_status_changed')
                    ->subject($subject)
                    ->with(['eventUser' => $this->eventUser]);
    }
}
