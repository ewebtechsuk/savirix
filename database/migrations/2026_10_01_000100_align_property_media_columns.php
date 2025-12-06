<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('property_media')) {
            return;
        }

        Schema::table('property_media', function (Blueprint $table) {
            if (! Schema::hasColumn('property_media', 'media_type')) {
                $table->string('media_type')->default('photo')->after('property_id');
            }

            if (! Schema::hasColumn('property_media', 'media_url')) {
                $table->string('media_url')->nullable()->after('media_type');
            }
        });

        $this->ensureColumnDefinitions();
    }

    public function down(): void
    {
        // Schema alignment migration is intentionally non-destructive.
    }

    protected function ensureColumnDefinitions(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            if (Schema::hasColumn('property_media', 'media_type')) {
                DB::statement("ALTER TABLE `property_media` MODIFY `media_type` varchar(255) NOT NULL DEFAULT 'photo'");
            }

            if (Schema::hasColumn('property_media', 'media_url')) {
                DB::statement("ALTER TABLE `property_media` MODIFY `media_url` varchar(255) NULL");
            }
        }
    }
};
