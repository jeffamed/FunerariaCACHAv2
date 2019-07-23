<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechasFinanciamiento extends Model
{
    protected $fillable = [
        'id',
        'idFinanciamiento',
        'Fecha_PropuestaP',
        'Fecha_Cobro',
        'Estado'
    ];
    public function financiamiento()
    {
        return $this->belongsTo('App\Financiamiento');
    }
}
