<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->macAddress('monitor_mac');
            $table->float('temperature')->nullable(true);
            $table->float('humidity')->nullable(true);
            $table->float('air_pressure')->nullable(true);
            $table->integer('movement')->nullable(true);
            $table->float('luminosity')->nullable(true);
            $table->float('heat_index')->nullable(true);
            $table->float('avg_sound')->nullable(true);
            $table->timestamps();

            $table
                ->foreign('monitor_mac')
                ->references('mac_address')
                ->on('monitors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('measurements');
    }
}
