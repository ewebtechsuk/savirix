<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            AdminUserSeeder::class,
            ContactTagGroupSeeder::class,
            DemoDataSeeder::class, // Add demo data seeder
            CreateSuperAdminSeeder::class,
            TenantPortalUserSeeder::class,
<<<<<<< HEAD
=======
            AgentKnowledgeSeeder::class,
>>>>>>> fb26402d0c5ab29406a97c02a62d89a691073565
        ]);
    }
}
