<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechasContrato extends Model
{
    protected $table = 'fechascontratos';

    protected $fillable = [
        'id',
        'idContrato',
        'Fecha_PropuestaP',
        'Fecha_Cobro',
        'Estado'
    ];
	public function contrato()
    {
        return $this->belongsTo('App\Contrato');
    }
}
