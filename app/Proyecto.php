<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $fillable = [
        'id',
        'Nombre',
        'Descripcion',
        'Estado'
    ];
}
