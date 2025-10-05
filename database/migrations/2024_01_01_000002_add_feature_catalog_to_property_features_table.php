<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('property_features')) {
            return;
        }

        Schema::table('property_features', function (Blueprint $table) {
            if (! Schema::hasColumn('property_features', 'feature_catalog_id')) {
                $table->foreignId('feature_catalog_id')
                    ->nullable()
                    ->after('property_id')
                    ->constrained('property_feature_catalogs')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('property_features', 'meta')) {
                $table->json('meta')->nullable()->after('value');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('property_features')) {
            return;
        }

        Schema::table('property_features', function (Blueprint $table) {
            if (Schema::hasColumn('property_features', 'feature_catalog_id')) {
                $table->dropForeign(['feature_catalog_id']);
                $table->dropColumn('feature_catalog_id');
            }

            if (Schema::hasColumn('property_features', 'meta')) {
                $table->dropColumn('meta');
            }
        });
    }
};
