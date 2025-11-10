<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtPropertiesMoreinfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties_moreinfos', function(Blueprint $table)
        {        
            $table->increments('id');
            $table->integer('property')->nullable()->default(null);
            $table->integer('branch')->nullable()->default(null);
            $table->integer('negotiator')->nullable()->default(null);
            $table->integer('agent_does_viewing')->nullable()->default(null);
            $table->text('comments')->nullable()->default(null);
            $table->tinyInteger('DSSaccepted')->nullable()->default(false);
            $table->tinyInteger('DSSrejected')->nullable()->default(false);
            $table->string('councilTaxBand', 10)->nullable()->default(null);
            $table->string('councilTaxAmount')->nullable()->default(null);
            $table->string('gasmeterReading')->nullable()->default(null);
            $table->string('eletricMeterReading')->nullable()->default(null);
            $table->string('period', 50)->nullable()->default(null);
            $table->string('stva', 50)->nullable()->default(null);
            $table->string('tenure', 50)->nullable()->default(null);
            $table->string('streetview', 10)->nullable()->default(null);
            $table->integer('agreedCommission')->nullable()->default(null);
            $table->string('council', 50)->nullable()->default(null);
            $table->string('council_band')->nullable()->default(null);
            $table->string('freeholder')->nullable()->default(null);
            $table->string('freeholder_contact')->nullable()->default(null);
            $table->text('freeholder_address')->nullable()->default(null);
            $table->string('occup_name')->nullable()->default(null);
            $table->string('occup_email')->nullable()->default(null);
            $table->string('occup_mobile')->nullable()->default(null);
            //$table->integer('photo_filename')->nullable()->default(null);
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
        Schema::drop('properties_moreinfos');
    }
}
