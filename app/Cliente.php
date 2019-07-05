<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'id',
        'idBarrio',
        'Nombre',
        'Apellido',
        'Direccion',
        'Estado_Civil',
        'Telefono',
        'Cedula',
        'Estado'
    ];
    public function barrio()
    {
        return $this->belongsTo('App\Barrio');
    }
}
