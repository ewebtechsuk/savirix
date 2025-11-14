<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Stancl\Tenancy\Database\Models\Domain;

class AktonzTenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = 'aktonz';
        $domain = 'aktonz.savarix.com';

        $tenantData = [
            'slug' => $tenantId,
            'name' => 'Aktonz Estate Agents',
            'company_name' => 'Aktonz Estate Agents',
            'company_email' => 'info@aktonz.com',
            'email' => 'info@aktonz.com',
            'company_id' => '468173',
            'client_name' => 'Aktonz Estate Agents',
            'domains' => [$domain],
        ];

        $tenant = Tenant::query()->updateOrCreate(
            ['id' => $tenantId],
            [
                'name' => 'Aktonz Estate Agents',
                'data' => $tenantData,
            ]
        );

        Domain::query()->updateOrCreate(
            ['domain' => $domain],
            ['tenant_id' => $tenant->getKey()]
        );

        $userAttributes = [
            'name' => 'Aktonz Admin',
            'email' => 'info@aktonz.com',
            'password' => Hash::make('AktonzTempPass123!'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ];

        if (Schema::hasColumn('users', 'tenant_id')) {
            $userAttributes['tenant_id'] = $tenant->getKey();
        }

        if (Schema::hasColumn('users', 'company_id')) {
            $userAttributes['company_id'] = $tenantData['company_id'];
        }

        User::query()->updateOrCreate(
            ['email' => 'info@aktonz.com'],
            $userAttributes
        );
    }
}
