<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtLandlords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landlords', function(Blueprint $table)
        {
            $table->increments('id');
            $table->tinyInteger('person_landlord')->nullable()->default(null);
            $table->tinyInteger('person_vendor')->nullable()->default(null);            
            $table->string('person_type', 15)->nullable()->default(null);
            $table->string('person_title', 10)->nullable()->default(null);
            $table->string('person_salutation')->nullable()->default(null);
            $table->string('person_firstname')->nullable()->default(null);
            $table->string('person_lastname')->nullable()->default(null);
            $table->string('person_company')->nullable()->default(null);
            $table->string('corres_postcode')->nullable()->default(null);
            $table->string('corres_address_first')->nullable()->default(null);
            $table->string('corres_address_second')->nullable()->default(null);
            $table->string('corres_town')->nullable()->default(null);
            $table->string('corres_city')->nullable()->default(null);
            $table->string('corres_country')->nullable()->default(null);
            $table->string('contact_phone_home', 50)->nullable()->default(null);
            $table->string('contact_phone_work', 50)->nullable()->default(null);
            $table->string('contact_phone_mobile', 50)->nullable()->default(null);
            $table->string('contact_fax')->nullable()->default(null);
            $table->string('contact_email')->nullable()->default(null);
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
        Schema::drop('landlords');
    }
}
