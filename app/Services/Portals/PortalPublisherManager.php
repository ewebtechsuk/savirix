<?php

namespace App\Services\Portals;

use App\Models\Property;
use App\Models\PropertyChannel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class PortalPublisherManager
{
    /**
     * Publish a property to a specific channel using its configured handler.
     */
    public function publish(Property $property, PropertyChannel $channel): PortalPublisherResult
    {
        $handler = $channel->handler;

        if (! $channel->is_active) {
            return new PortalPublisherResult(false, null, ['reason' => 'Channel is disabled']);
        }

        if (empty($handler) || ! class_exists($handler)) {
            return new PortalPublisherResult(true, null, ['note' => 'No handler configured']);
        }

        /** @var PortalPublisher $publisher */
        $publisher = App::make($handler);

        return $publisher->publish($property);
    }
}
