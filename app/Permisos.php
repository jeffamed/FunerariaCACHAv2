<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    protected $table = 'permissions';

    protected $fillable =[
        'id',
        'name',
        'slug',
        'description'
    ];
}
