<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TasaCambio extends Model
{
    protected $table = 'tasacambios';

    protected $fillable = [
        'id',
        'Monto'
    ];

    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }
}
