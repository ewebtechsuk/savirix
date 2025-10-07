<?php

namespace App\Services\Messaging;

class CommunicationResult
{
    public function __construct(
        public readonly bool $success,
        public readonly string $provider,
        public readonly ?string $messageId = null,
        public readonly array $meta = []
    ) {
    }
}
