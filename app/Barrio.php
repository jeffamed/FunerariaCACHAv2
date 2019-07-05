<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    protected $filable = [
        'id',
        'idZona',
        'Nombre'
    ];

    public function zona()
    {
        return $this->belongsTo('App\Zona');
    }

    public function clientes()
    {
        return $this->hasMany('App\Cliente');
    }
}
