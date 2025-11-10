<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtLandlordsInternals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landlords_internals', function(Blueprint $table)
        {        
            $table->integer('landlords_id')->nullable()->default(null);
            $table->string('internal_other_label', 50)->nullable()->default(null);
            $table->string('internal_other_status', 50)->nullable()->default(null);
            $table->integer('internal_other_branch')->nullable()->default(null);
            $table->string('internal_other_negotiator')->nullable()->default(null);
            $table->string('internal_other_lead', 50)->nullable()->default(null);
            $table->text('internal_comment')->nullable()->default(null);
            $table->text('internal_other_info')->nullable()->default(null);
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
        Schema::drop('landlords_internals');
    }
}
