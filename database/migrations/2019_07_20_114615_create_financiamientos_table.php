<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanciamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financiamientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idContrato');
            $table->integer('Financiamiento');
            $table->float('PorcentajeFin');
            $table->float('Total');
            $table->float('SubTotal');
            $table->string('Frecuencia_Pago');
            $table->integer('numero_Frec');
            $table->float('Cuota');
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
        Schema::dropIfExists('financiamientos');
    }
}
