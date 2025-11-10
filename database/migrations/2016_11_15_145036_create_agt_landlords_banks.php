<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtLandlordsBanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landlords_banks', function(Blueprint $table)
        {        
            $table->integer('landlords_id')->nullable()->default(null);
            $table->string('bank_body')->nullable()->default(null);
            $table->string('bank_account_no')->nullable()->default(null);
            $table->string('bank_sort_code')->nullable()->default(null);
            $table->string('bank_accunt_name')->nullable()->default(null);
            $table->string('bank_branch_addr_first')->nullable()->default(null);
            $table->string('bank_branch_addr_second')->nullable()->default(null);
            $table->string('bank_branch_town')->nullable()->default(null);
            $table->string('bank_branch_city')->nullable()->default(null);
            $table->string('bank_branch_postcode')->nullable()->default(null);
            $table->string('bank_branch_country')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('landlords_banks');
    }
}
