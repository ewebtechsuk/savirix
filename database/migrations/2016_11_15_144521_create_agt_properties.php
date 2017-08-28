<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function(Blueprint $table)
        {
            $table->increments('id');
            
            $table->integer('landlord')->nullable()->default(null);
            /* Property on market */
            $table->integer('for')->nullable()->default(null);
            $table->integer('let_type')->nullable()->default(null);
            $table->string('service_type', 50)->nullable()->default(null);
            $table->string('available', 20)->nullable()->default(null);
            $table->string('furniture', 50)->nullable()->default(null);            
            $table->tinyInteger('pets')->nullable()->default(false);
            $table->tinyInteger('smoking')->nullable()->default(false);
            $table->integer('category')->nullable()->default(null);
            $table->integer('property_type')->nullable()->default(null);
            $table->string('internal_reference')->nullable()->default(null);
            /* Rent and contract */
            $table->tinyInteger('student_let')->nullable()->default(false);
            
            $table->string('price_deposit')->nullable()->default("");
            $table->string('deposit_unit', 10)->nullable()->default("");

            $table->string('price_rent2')->nullable()->default("");
            $table->string('currency2', 10)->nullable()->default("");


            $table->string('price_rent', 50)->nullable()->default(null);
            $table->integer('currency')->nullable()->default(null);
            $table->string('renewal_fee')->nullable()->default(null);
            $table->string('price_qualifier', 50)->nullable()->default(null);
            $table->string('contract', 50)->nullable()->default(null);
            $table->decimal('finder_fee', 5, 2)->nullable()->default(0.00);
            $table->string('finder_fee_unit', 10)->nullable()->default(null);
            $table->string('listing_commission')->nullable()->default(null);
            $table->string('listing_commission_unit', 10)->nullable()->default(null);
            $table->string('selling_commission')->nullable()->default(null);
            $table->string('selling_commission_unit', 10)->nullable()->default(null);
            $table->decimal('management_fee', 5, 2)->nullable()->default(0.00);
            $table->string('management_fee_unit', 10)->nullable()->default(null);
            /* Address of property on market */
            $table->string('addr_postcode')->nullable()->default(null);
            $table->string('property_no')->nullable()->default(null);
            $table->string('property_name')->nullable()->default(null);
            $table->string('add1')->nullable()->default(null);
            $table->string('add2')->nullable()->default(null);
            $table->string('area', 50)->nullable()->default(null);
            $table->string('county', 50)->nullable()->default(null);
            $table->string('country', 50)->nullable()->default(null);  
            /* Composition */
            $table->integer('beds')->nullable()->default(null);
            $table->integer('baths')->nullable()->default(null);
            $table->integer('receptions')->nullable()->default(null);
            $table->string('parking')->nullable()->default(null);
            $table->string('livingspace')->nullable()->default(null);
            $table->string('landsize')->nullable()->default(null);
            $table->integer('outbuildings')->nullable()->default(null);

            $table->timestamps();
            $table->softDeletes();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('properties');
    }
}
