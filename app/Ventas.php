<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = "ventas";

    protected $fillable = [
        'id',
        'idCliente',
        'cambioDolar',
        'total',
        'totalDolar',
        'estado',
        'motivoAnulacion',
        'created_at',
        'updated_at'
    ];
}
