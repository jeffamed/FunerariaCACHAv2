<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFechasFinanciamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechas_financiamientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idFinanciamiento');
            $table->date('Fecha_PropuestaP');
            $table->date('Fecha_Cobro');
            $table->string('Estado',10)->default('Por Cobrar');
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
        Schema::dropIfExists('fechas_financiamientos');
    }
}
