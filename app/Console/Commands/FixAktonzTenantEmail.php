<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;

class FixAktonzTenantEmail extends Command
{
    protected $signature = 'tenant:fix-aktonz-email';
    protected $description = 'Ensure Aktonz tenant has company_email set to info@aktonz.com';

    public function handle()
    {
        $tenant = Tenant::where('data->company_id', '468173')->first();
        if (!$tenant) {
            $this->error('Aktonz tenant not found.');
            return 1;
        }
        $data = $tenant->data ?? [];
        $data['company_email'] = 'info@aktonz.com';
        $tenant->data = $data;
        $tenant->save();
        $this->info('Aktonz tenant company_email set to info@aktonz.com');
        return 0;
    }
}
