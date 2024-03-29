<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable = [
        'id',
        'idDolar',
        'idCxC',
        'TipoDocumento',
        'Fecha_Pago',
        'Monto',
        'Estado',
        'MontoDolar',
        'Anulacion',
        'Documento',
        'TotalRestante',
        'usuario',
        'idcliente'
    ];

    public function contrato()
    {
        return $this->belongsTo('App\Contrato');
    }

    public function tasa()
    {
        return $this->belongsTo('App\TasaCambio');
    }
}
