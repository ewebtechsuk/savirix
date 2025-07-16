<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtPropertiesInternals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties_internals', function(Blueprint $table)
        {       
            $table->increments('id'); 
            $table->integer('property')->nullable()->default(null);
            $table->tinyInteger('publish')->nullable()->default(false);
            $table->string('status', 50)->nullable()->default(null);
            $table->string('portal_publish', 10)->nullable()->default(false);
            $table->integer('portal_status')->nullable()->default(null);
            $table->integer('portal_for')->nullable()->default(null);
            $table->integer('portal_type')->nullable()->default(null);
            $table->tinyInteger('new_home')->nullable()->default(false);
            $table->string('rm_add')->nullable()->default(null);
            $table->string('vt_url')->nullable()->default(null);
            $table->string('vt_url2')->nullable()->default(null);
            $table->string('pb_url')->nullable()->default(null);
            $table->text('admin_fee')->nullable()->default(null);
            $table->text('portal_details')->nullable()->default(null);
            $table->text('portal_summary')->nullable()->default(null);
            
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
        Schema::drop('properties_internals');
    }
}
