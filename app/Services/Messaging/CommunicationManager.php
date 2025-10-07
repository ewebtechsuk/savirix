<?php

namespace App\Services\Messaging;

use App\Models\Contact;
use Illuminate\Support\Facades\App;
use InvalidArgumentException;

class CommunicationManager
{
    /**
     * @param array<string, class-string<CommunicationChannel>> $channels
     */
    public function __construct(private readonly array $channels = [])
    {
    }

    public function send(Contact $contact, string $channel, array $payload): CommunicationResult
    {
        $map = $this->channels ?: config('communications.channels', []);

        if (! isset($map[$channel])) {
            throw new InvalidArgumentException("Channel {$channel} is not supported");
        }

        $handlerClass = $map[$channel];
        /** @var CommunicationChannel $handler */
        $handler = App::make($handlerClass);

        return $handler->send($contact, $payload);
    }
}
