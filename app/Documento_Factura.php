<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento_Factura extends Model
{
    protected $fillable = [
        'id',
        'idDocumento',
        'Fecha_PropuestaP',
        'Fecha_Cobro',
        'Estado'
    ];
}
