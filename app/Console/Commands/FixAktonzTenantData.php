<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;

class FixAktonzTenantData extends Command
{
    protected $signature = 'tenant:fix-aktonz-data';
    protected $description = 'Ensure Aktonz tenant has correct company_name and company_email in data field';

    public function handle()
    {
        $tenants = Tenant::where('data->company_id', '468173')->get();
        if ($tenants->isEmpty()) {
            $this->error('No relevant tenants found.');
            return 1;
        }
        foreach ($tenants as $tenant) {
            $data = is_array($tenant->data) ? $tenant->data : [];
            if ($tenant->data['company_id'] === '468173') {
                $data['company_name'] = 'Aktonz';
                $data['company_email'] = 'info@aktonz.com';
                $data['website'] = 'https://aktonz.com';
            } elseif ($tenant->id === 'haringeyestaets') {
                $data['company_name'] = 'Haringey Estates';
                $data['company_email'] = 'info@haringeyestates.com';
                $data['website'] = 'https://haringeyestates.com';
                $data['client_name'] = 'Default Client';
            }
            $tenant->data = $data;
            $tenant->save();
        }
        $this->info('All relevant tenant data updated.');
        return 0;
    }
}
