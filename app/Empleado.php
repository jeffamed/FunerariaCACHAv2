<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'id',
        'Nombre',
        'Apellido',
        'Direccion',
        'Telefono',
        'Cedulo',
        'Estado'
    ];

    public function zona()
    {
        return $this->belongsTo('App\Zona');
    }

    public function accesos()
    {
        return $this->hasMany('App\Acceso');
    }
}
