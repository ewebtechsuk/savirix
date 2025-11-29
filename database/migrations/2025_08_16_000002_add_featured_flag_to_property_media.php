<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('property_media')) {
            return;
        }

        $orderColumnExists = Schema::hasColumn('property_media', 'order');

        Schema::table('property_media', function (Blueprint $table) use ($orderColumnExists) {
            if (! Schema::hasColumn('property_media', 'is_featured')) {
                $column = $table->boolean('is_featured')->default(false);

                if ($orderColumnExists) {
                    $column->after('order');
                }
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('property_media')) {
            return;
        }

        if (Schema::hasColumn('property_media', 'is_featured')) {
            Schema::table('property_media', function (Blueprint $table) {
                $table->dropColumn('is_featured');
            });
        }
    }
};
