<?php

namespace App\Services\Messaging\Channels;

use App\Models\Contact;
use App\Services\Messaging\CommunicationChannel;
use App\Services\Messaging\CommunicationResult;
use Illuminate\Support\Facades\Http;

class SmsChannel implements CommunicationChannel
{
    public function send(Contact $contact, array $payload): CommunicationResult
    {
        $config = config('services.twilio');
        $message = $payload['body'] ?? '';

        $response = Http::withBasicAuth($config['sid'] ?? '', $config['token'] ?? '')
            ->post($config['endpoint'] ?? '', [
                'To' => $contact->phone,
                'From' => $config['from'] ?? null,
                'Body' => $message,
            ]);

        $success = $response->successful();

        return new CommunicationResult(
            $success,
            'twilio',
            $response->json('sid') ?? null,
            ['status' => $response->status(), 'body' => $response->json()]
        );
    }
}
