<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechascontratos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idContrato');
            $table->date('Fecha_PropuestaP');
            $table->date('Fecha_Cobro');
            $table->string('Estado',10);
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
        Schema::dropIfExists('fechascontratos');
    }
}
