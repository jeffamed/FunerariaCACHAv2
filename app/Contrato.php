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
        'SaldoR',
        'Fecha_Emision',
        'Frecuencia_Pago',
        'Numero_Frecuencia',
        'Estado',
        'Descuento',
        'Beneficiarios',
        'Nota',
        'Cuota',
        'cancelado'
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
    public function documentofactura()
    {
        return $this->hasMany('App\FechasContrato');
    }
    public function facturas()
    {
        return $this->hasMany('App\Facturas');
    }
    public function financiamiento()
    {
        return $this->belongsTo('App\Financiamiento');
    }
    public function cuentaxcobrar()
    {
        return $this->hasMany('App\CuentaszCobrar');
    }
}
