<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Financiamiento extends Model
{
    protected $table = 'financiamientos';

    protected $fillable = [
        'id',
        'idContrato',
        'Financiamiento',
        'PorcentajeFin',
        'Total',
        'SubTotal',
        'Frecuencia_Pago',
        'numero_Frec',
        'SaldoR',
        'Cuota',
        'Estado'
    ];

    public function contrato()
    {
        return $this->hasOne('App\Contrato');
    }
    public function fechaf()
    {
        return $this->hasMany('App\FechasFinanciamiento');
    }
    public function cuentas()
    {
        return $this->hasMany('App\CuentasxCobrar');
    }
}
