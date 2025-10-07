<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('property_media')) {
            return;
        }

        Schema::table('property_media', function (Blueprint $table) {
            if (! Schema::hasColumn('property_media', 'disk')) {
                $table->string('disk')->default('public')->after('type');
            }
            if (! Schema::hasColumn('property_media', 'caption')) {
                $table->string('caption')->nullable()->after('order');
            }
            if (! Schema::hasColumn('property_media', 'is_primary')) {
                $table->boolean('is_primary')->default(false)->after('caption');
            }
            if (! Schema::hasColumn('property_media', 'conversions')) {
                $table->json('conversions')->nullable()->after('is_primary');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('property_media')) {
            return;
        }

        Schema::table('property_media', function (Blueprint $table) {
            foreach (['disk', 'caption', 'is_primary', 'conversions'] as $column) {
                if (Schema::hasColumn('property_media', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
