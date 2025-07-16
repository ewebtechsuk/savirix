<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtLandlordsAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landlords_attachments', function(Blueprint $table)
        {        
            $table->integer('landlords_id')->nullable()->default(null);
            $table->string('file_format', 10)->nullable()->default(null);
            $table->string('file_name')->nullable()->default(null);
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
        Schema::drop('landlords_attachments');
    }
}
