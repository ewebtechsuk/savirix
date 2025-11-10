<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixNullTenantData extends Migration
{
    public function up()
    {
        // Set all null data fields to empty JSON object
        DB::table('tenants')->whereNull('data')->update(['data' => json_encode(new stdClass())]);
    }

    public function down()
    {
        // No rollback needed
    }
}
