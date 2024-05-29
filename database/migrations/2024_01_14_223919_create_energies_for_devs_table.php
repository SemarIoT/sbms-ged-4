<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnergiesForDevsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('energies_for_devs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kwh');
            $table->float('frekuensi')->nullable(true);
            $table->float('arus')->nullable(true);
            $table->float('tegangan')->nullable(true);
            $table->float('active_power')->nullable(true);
            $table->float('reactive_power')->nullable(true);
            $table->float('apparent_power')->nullable(true);
            $table->float('total_energy')->nullable(true);
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
        Schema::dropIfExists('energies_for_devs');
    }
}
