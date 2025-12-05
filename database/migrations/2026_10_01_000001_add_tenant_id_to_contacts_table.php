<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('contacts', 'tenant_id')) {
            Schema::table('contacts', function (Blueprint $table) {
                // Existing rows will remain NULL until we can reliably backfill
                // them against a known tenant. This keeps the migration
                // repeatable while we finalise the mapping strategy.
                $table->string('tenant_id')->nullable()->after('id');
                $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('contacts', 'tenant_id')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropForeign(['tenant_id']);
                $table->dropColumn('tenant_id');
            });
        }
    }
};
