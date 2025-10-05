<?php

namespace App\Services\Portals;

use App\Models\Property;

interface PortalPublisher
{
    public function publish(Property $property): PortalPublisherResult;
}
