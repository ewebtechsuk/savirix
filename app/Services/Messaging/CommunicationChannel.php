<?php

namespace App\Services\Messaging;

use App\Models\Contact;

interface CommunicationChannel
{
    public function send(Contact $contact, array $payload): CommunicationResult;
}
