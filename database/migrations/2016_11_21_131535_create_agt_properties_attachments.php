<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtPropertiesAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Guard this table because the production schema already includes it
        // from the pre-Laravel deployment.
        if (Schema::hasTable('properties_attachments')) {
            return;
        }

        Schema::create('properties_attachments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('property')->nullable()->default(null);
            $table->string('section')->nullable()->default("");
            $table->string('file_name')->nullable()->default("");
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
        Schema::dropIfExists('properties_attachments');
    }
}
