<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;

class AssignCompanyIds extends Command
{
    protected $signature = 'assign:company-ids';
    protected $description = 'Assign a unique random 4-6 digit company_id to all tenants missing one';

    public function handle()
    {
        $updated = 0;
        $tenants = Tenant::all();
        foreach ($tenants as $tenant) {
            $data = $tenant->data ?? [];
            if (empty($data['company_id'])) {
                // Generate unique 4-6 digit company_id
                do {
                    $company_id = str_pad(random_int(1000, 999999), 4, '0', STR_PAD_LEFT);
                } while (Tenant::where('data->company_id', $company_id)->exists());
                $data['company_id'] = $company_id;
                $tenant->data = $data;
                $tenant->save();
                $updated++;
                $this->info("Assigned company_id $company_id to tenant {$tenant->id}");
            }
        }
        $this->info("Done. Updated $updated tenants.");
    }
}
