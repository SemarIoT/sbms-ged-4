<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnergiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('energies', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kwh');
            $table->float('i_A');
            $table->float('i_B');
            $table->float('i_C');
            $table->float('v_A');
            $table->float('v_B');
            $table->float('v_C');
            $table->float('p_A');
            $table->float('p_B');
            $table->float('p_C');
            $table->float('pf_A');
            $table->float('pf_B');
            $table->float('pf_C');
            $table->float('frekuensi');
            $table->float('reactive_power');
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
        Schema::dropIfExists('energies');
    }
}
