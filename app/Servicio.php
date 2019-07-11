<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'id',
        'idProyecto',
        'Nombre',
        'Descripcion',
        'Monto',
        'Estado'
    ];

    public function proyecto()
    {
        return $this->belongsTo('App\Proyecto');
    }
}
