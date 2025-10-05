<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactCommunicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $subjectLine, public string $body)
    {
    }

    public function build(): self
    {
        return $this->subject($this->subjectLine)
            ->view('emails.contact_communication')
            ->with(['content' => $this->body]);
    }
}
