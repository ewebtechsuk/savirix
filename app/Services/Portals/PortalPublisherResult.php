<?php

namespace App\Services\Portals;

class PortalPublisherResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ?string $providerMessageId = null,
        public readonly array $meta = []
    ) {
    }
}
