<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactGroup;
use Illuminate\Support\Facades\DB;

class ContactTagGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed some tags (in the tags table)
        $tags = ['VIP', 'Newsletter', 'Do Not Contact', 'Investor'];
        foreach ($tags as $tag) {
            DB::table('tags')->updateOrInsert(['name' => $tag]);
        }

        // Seed some groups
        $groups = ['Landlords', 'Tenants', 'Vendors', 'Applicants'];
        foreach ($groups as $group) {
            ContactGroup::firstOrCreate(['name' => $group]);
        }
    }
}
