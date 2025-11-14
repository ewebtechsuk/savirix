<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgtPropertiesPortals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Production snapshots bundle the properties_portals table already; the
        // guard below keeps `artisan migrate` from erroring when re-run.
        if (Schema::hasTable('properties_portals')) {
            return;
        }

        Schema::create('properties_portals', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('property')->nullable()->default(null);
            $table->tinyInteger('find_a_property')->nullable()->default(false);
            $table->tinyInteger('globrix')->nullable()->default(false);
            $table->tinyInteger('gumtree')->nullable()->default(false);
            $table->tinyInteger('home_hunter')->nullable()->default(false);
            $table->tinyInteger('homes24')->nullable()->default(false);
            $table->tinyInteger('look_a_property')->nullable()->default(false);
            $table->tinyInteger('movehut')->nullable()->default(false);
            $table->tinyInteger('market')->nullable()->default(false);
            $table->tinyInteger('primelocation')->nullable()->default(false);
            $table->tinyInteger('property_finder')->nullable()->default(false);
            $table->tinyInteger('property_index')->nullable()->default(false);
            $table->tinyInteger('propertylive')->nullable()->default(false);
            $table->tinyInteger('rightmove')->nullable()->default(false);
            $table->tinyInteger('rightmove_overseas')->nullable()->default(false);
            $table->tinyInteger('zoomf')->nullable()->default(false);
            $table->tinyInteger('zoopla')->nullable()->default(false);
            $table->tinyInteger('zoopla_overseas')->nullable()->default(false);
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
        Schema::dropIfExists('properties_portals');
    }
}
