<?php

namespace App\Services\Messaging\Channels;

use App\Mail\ContactCommunicationMail;
use App\Models\Contact;
use App\Services\Messaging\CommunicationChannel;
use App\Services\Messaging\CommunicationResult;
use Illuminate\Support\Facades\Mail;

class EmailChannel implements CommunicationChannel
{
    public function send(Contact $contact, array $payload): CommunicationResult
    {
        $subject = $payload['subject'] ?? 'Message from Ressapp';
        $body = $payload['body'] ?? '';

        Mail::to($contact->email)->send(new ContactCommunicationMail($subject, $body));

        return new CommunicationResult(true, 'mail', null, [
            'subject' => $subject,
        ]);
    }
}
