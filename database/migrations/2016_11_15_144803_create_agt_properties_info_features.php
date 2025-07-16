<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtPropertiesInfoFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties_info_features', function(Blueprint $table)
        {        
            $table->increments('id');
            $table->integer('property')->nullable()->default(null);
            $table->tinyInteger('fully_furnished')->nullable()->default(false);
            $table->tinyInteger('shops_amenities_nearby')->nullable()->default(false);
            $table->tinyInteger('gym')->nullable()->default(false);
            $table->tinyInteger('mezzanine')->nullable()->default(false);
            $table->tinyInteger('en_suite')->nullable()->default(false);
            $table->tinyInteger('double_glazing')->nullable()->default(false);
            $table->tinyInteger('concierge')->nullable()->default(false);
            $table->tinyInteger('un_furnished')->nullable()->default(false);
            $table->tinyInteger('garden')->nullable()->default(false);
            $table->tinyInteger('roof_terrace')->nullable()->default(false);
            $table->tinyInteger('underground_parking')->nullable()->default(false);
            $table->tinyInteger('parking')->nullable()->default(false);
            $table->tinyInteger('river_view')->nullable()->default(false);
            $table->tinyInteger('air_conditioning')->nullable()->default(false);
            $table->tinyInteger('guest_cloakroom')->nullable()->default(false);
            $table->tinyInteger('fitted_kitchen')->nullable()->default(false);
            $table->tinyInteger('video_entry')->nullable()->default(false);
            $table->tinyInteger('conservatory')->nullable()->default(false);
            $table->tinyInteger('transport')->nullable()->default(false);
            $table->tinyInteger('swimming_pool')->nullable()->default(false);
            $table->tinyInteger('communal_garden')->nullable()->default(false);
            $table->tinyInteger('balcony')->nullable()->default(false);
            $table->tinyInteger('driveway')->nullable()->default(false);
            $table->tinyInteger('meeting_room')->nullable()->default(false);
            $table->tinyInteger('receptionist')->nullable()->default(false);
            $table->tinyInteger('site_security')->nullable()->default(false);
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
        Schema::drop('properties_info_features');
    }
}
