<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtPropertiesDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Guard because Hostinger already has this table from the imported DB.
        if (Schema::hasTable('properties_descriptions')) {
            return;
        }

        Schema::create('properties_descriptions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('property')->nullable()->default(null);
            $table->text('tinymceModel')->nullable()->default(null);
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
        Schema::dropIfExists('properties_descriptions');
    }
}
