<?php

namespace App\Jobs;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Portals\PortalPublisherManager;
use Illuminate\Support\Facades\App;

class SyncPropertyToPortals implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Property $property)
    {
    }

    public function handle(): void
    {
        /** @var PortalPublisherManager $manager */
        $manager = App::make(PortalPublisherManager::class);

        $this->property->loadMissing(['media', 'features.catalog', 'channels']);

        foreach ($this->property->channels as $channel) {
            $result = $manager->publish($this->property, $channel);

            $this->property->channels()->updateExistingPivot($channel->id, [
                'status' => $result->success ? 'synced' : 'failed',
                'payload' => json_encode($result->meta),
                'last_synced_at' => now(),
            ]);
        }
    }
}
