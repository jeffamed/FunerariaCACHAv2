<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Financiamiento extends Model
{
    protected $fillable = [
        'id',
        'idContrato',
        'Financiamiento',
        'PorcentajeFin',
        'Total',
        'SubTotal',
        'Frecuencia_Pago',
        'numero_Frec',
        'Cuota'
    ];

    public function contrato()
    {
        return $this->hasOne('App\Contrato');
    }
    public function fechaf()
    {
        return $this->hasMany('App\FechasFinanciamiento');
    }
}