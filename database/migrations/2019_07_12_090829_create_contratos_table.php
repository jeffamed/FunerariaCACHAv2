<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Contrato',50);
            $table->integer('idCliente');
            $table->integer('idVendedor');
            $table->integer('idServicio'); 
            $table->float('Total');
            $table->date('Fecha_Emision');
            $table->string('Frecuencia_Pago',10);
            $table->string('Estado', 10);
            $table->float('Descuento');
            $table->string('Beneficiarios', 1000);
            $table->string('Nota', 1000)->nullable();
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
        Schema::dropIfExists('contratos');
    }
}
