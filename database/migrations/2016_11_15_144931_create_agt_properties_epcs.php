<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtPropertiesEpcs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties_epcs', function(Blueprint $table)
        {        
            $table->increments('id');
            $table->integer('property')->nullable()->default(null);
            $table->string('what_rep', 10)->nullable()->default(null);
            $table->string('report_file')->nullable()->default(null);
            $table->string('epc_url')->nullable()->default(null);
            $table->tinyInteger('show_video_tour')->nullable()->default(false);
            $table->text('video_tour')->nullable()->default(null);
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
        Schema::drop('properties_epcs');
    }
}
