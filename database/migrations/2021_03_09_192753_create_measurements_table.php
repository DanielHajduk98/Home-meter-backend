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
            $table->unsignedBigInteger('monitor_id');
            $table->float('temperature');
            $table->float('humidity');
            $table->float('air_pressure');
            $table->integer('movement');
            $table->float('luminosity');
            $table->float('heat_index');
            $table->timestamps();

            $table
                ->foreign('monitor_id')
                ->references('id')
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
