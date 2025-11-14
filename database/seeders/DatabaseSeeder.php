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
            AgentKnowledgeSeeder::class,
        ]);

        if (app()->environment(['local', 'staging'])) {
            // Seed a working Aktonz tenant locally so developers can reproduce
            // the Hostinger configuration without touching production data.
            $this->call(AktonzTenantSeeder::class);
        }
    }
}
