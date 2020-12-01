<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVentas extends Model
{
    protected $table="detalle_venta";

    protected $fillable = [
        'id',
        'idVenta',
        'idServicio',
        'cantidad',
        'precio',
        'created_at',
        'updated_at'
    ];
}
