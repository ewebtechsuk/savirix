<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixTenantsDataColumnType extends Migration
{
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->json('data')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->text('data')->nullable()->change(); // revert to text if needed
        });
    }
}
