<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $fillable = [
        'id',
        'idColector',
        'Nombre',
        'idMunicipio',
        'Estado'
    ];

    public function empleados()
    {
        return $this->hasMany('App\Empleado');
    }
    public function municipio()
    {
        return $this->belongsTo('App\Municipios');
    }
}
