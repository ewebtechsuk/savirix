<?php

namespace Database\Seeders;

use App\Models\PropertyChannel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertyChannelSeeder extends Seeder
{
    public function run(): void
    {
        $channels = [
            ['name' => 'Rightmove', 'slug' => 'rightmove', 'handler' => \App\Services\Portals\RightmovePortalPublisher::class],
            ['name' => 'Zoopla', 'slug' => 'zoopla', 'handler' => \App\Services\Portals\ZooplaPortalPublisher::class],
            ['name' => 'Company Website', 'slug' => 'website', 'handler' => null],
        ];

        foreach ($channels as $channel) {
            PropertyChannel::updateOrCreate(
                ['slug' => Str::slug($channel['slug'])],
                ['name' => $channel['name'], 'handler' => $channel['handler']]
            );
        }
    }
}
