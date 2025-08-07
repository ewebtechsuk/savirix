<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;

class CreateAktonzTenant extends Command
{
    protected $signature = 'tenant:create-aktonz';
    protected $description = 'Create Aktonz tenant with company_name and company_email';

    public function handle()
    {
        $data = [
            'company_name' => 'Aktonz',
            'company_email' => 'info@aktonz.com',
            'website' => 'https://aktonz.com',
            'client_name' => 'Shah Chowdhury',
        ];
        $tenant = new Tenant();
        $tenant->id = uniqid('aktonz_');
        $tenant->data = $data;
        $tenant->save();
        $this->info('Aktonz tenant created with ID: ' . $tenant->id);
        return 0;
    }
}
