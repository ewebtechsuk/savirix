<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Stancl\Tenancy\Database\Models\Domain;

class ListUsers extends Command
{
    protected $signature = 'users:list {--tenant= : Filter by tenant ID, slug, company ID, or domain} {--email= : Filter by an email address fragment} {--json : Output the result set as JSON}';

    protected $description = 'Inspect application users and optionally scope them to a tenant.';

    public function handle(): int
    {
        $query = User::query()->orderBy('email');

        if ($tenantFilter = $this->option('tenant')) {
            $tenant = $this->resolveTenant($tenantFilter);

            if ($tenant === null) {
                $this->error(sprintf('Unable to locate a tenant that matches "%s".', $tenantFilter));

                return self::INVALID;
            }

            $tenantConstraints = [];
            $companyId = $tenant->company_id ?? ($tenant->data['company_id'] ?? null);

            if (Schema::hasColumn('users', 'tenant_id')) {
                $tenantConstraints[] = ['tenant_id', $tenant->getKey()];
            }

            if ($companyId !== null && Schema::hasColumn('users', 'company_id')) {
                $tenantConstraints[] = ['company_id', $companyId];
            }

            if ($tenantConstraints === []) {
                $this->warn('users table does not expose tenant/company columns; showing all records.');
            } else {
                $query->where(function ($builder) use ($tenantConstraints) {
                    foreach ($tenantConstraints as $index => [$column, $value]) {
                        if ($index === 0) {
                            $builder->where($column, $value);
                        } else {
                            $builder->orWhere($column, $value);
                        }
                    }
                });
            }
        }

        if ($emailFilter = $this->option('email')) {
            $query->where('email', 'like', "%{$emailFilter}%");
        }

        $users = $query->get();

        if ($users->isEmpty()) {
            $this->warn('No users matched the supplied filters.');

            return self::SUCCESS;
        }

        if ($this->option('json')) {
            $payload = $users->map(fn (User $user) => [
                'id' => $user->id,
                'email' => $user->email,
                'is_admin' => (bool) $user->is_admin,
                'email_verified_at' => $user->email_verified_at,
                'tenant_id' => $user->tenant_id ?? null,
                'company_id' => $user->company_id ?? null,
                'created_at' => optional($user->created_at)->toDateTimeString(),
            ]);

            $this->line($payload->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            return self::SUCCESS;
        }

        $rows = $users->map(fn (User $user) => [
            $user->id,
            $user->email,
            $user->is_admin ? 'yes' : 'no',
            optional($user->email_verified_at)?->toDateTimeString() ?? '—',
            $user->tenant_id ?? '—',
            $user->company_id ?? '—',
            optional($user->created_at)?->toDateTimeString() ?? '—',
        ])->toArray();

        $this->table(
            ['ID', 'Email', 'Admin', 'Verified', 'Tenant ID', 'Company ID', 'Created'],
            $rows
        );

        $this->info(sprintf('Total users: %d', $users->count()));

        return self::SUCCESS;
    }

    private function resolveTenant(string $identifier): ?Tenant
    {
        $tenant = Tenant::query()
            ->where('id', $identifier)
            ->orWhere('data->slug', $identifier)
            ->orWhere('data->company_id', $identifier)
            ->first();

        if ($tenant) {
            return $tenant;
        }

        $domain = class_exists(Domain::class)
            ? Domain::query()->where('domain', $identifier)->first()
            : null;

        return $domain?->tenant;
    }
}
