<?php

namespace Database\Seeders;

use App\Models\PropertyFeatureCatalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertyFeatureCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            'Fully Furnished',
            'River view',
            'Shops and amenities nearby',
            'Air Conditioning',
            'Gym',
            'Guest cloakroom',
            'Mezzanine',
            'Fitted Kitchen',
            'Communal Garden',
            'Roof Terrace',
            'Balcony',
            'Underground Parking',
            'Driveway',
            'Parking',
            'En suite',
            'Video Entry',
            'Double glazing',
            'Conservatory',
            'Concierge',
            'Close to public transport',
            'Un-Furnished',
            'Swimming Pool',
            '24 hour on-site security',
            'Receptionist',
            'Meeting Room and Conference Facilities',
        ];

        foreach ($features as $feature) {
            PropertyFeatureCatalog::firstOrCreate(
                ['slug' => Str::slug($feature)],
                ['name' => $feature, 'portal_key' => Str::upper(Str::slug($feature, '_'))]
            );
        }
    }
}
