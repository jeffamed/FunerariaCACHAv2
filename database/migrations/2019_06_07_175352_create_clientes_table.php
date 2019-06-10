<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idBarrio');
            $table->string('Nombre', 100);
            $table->string('Apellido', 100);
            $table->string('Direccion', 1000);
            $table->string('Estado_Civil', 15);
            $table->string('Telefono', 10);
            $table->string('Cedula', 20);
            $table->string('Estado', 6)->default('Tipo A');
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
        Schema::dropIfExists('clientes');
    }
}
