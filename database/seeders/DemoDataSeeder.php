<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Property::factory(10)->create();
        \App\Models\Contact::factory(20)->create();
        \App\Models\Landlord::factory(5)->create();
        \App\Models\Applicant::factory(10)->create();
        \App\Models\Viewing::factory(15)->create();
        \App\Models\Inspection::factory(8)->create();
        \App\Models\DiaryEvent::factory(12)->create();
    }
}
