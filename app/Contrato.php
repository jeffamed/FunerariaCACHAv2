<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $fillable = [
        'id',
        'Contrato',
        'idCliente',
        'idVendedor',
        'idServicio',
        'Total',
        'Fecha_Emision',
        'Frecuencia_Pago',
        'Estado',
        'Descuento',
        'Beneficiarios',
        'Nota',
        'Cuota'
    ];

    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }
    public function vendedor()
    {
        return $this->belongsTo('App\Vendedor');
    }
    public function servicio()
    {
        return $this->belongsTo('App\Servicio');
    }
}
