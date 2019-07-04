<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{

    protected $fillable = [
        'idDepartamento',
        'Nombre',
        'Estado'
    ];

    public function departamento()
    {
        return $this->belongsTo('App\Departamento');
    }
    public function zonas()
    {
        return $this->hasMany('App\Zonas');
    }
}
