<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Departamento extends Model
{
    // protected $table = 'departamentos';
    
    // protected $primaryKey = 'id';

    protected $fillable=[
        'Nombre',
        'Estado'
    ];

    public function municipios(){
        return $this->hasMany('App\Municipio');
    }
}
