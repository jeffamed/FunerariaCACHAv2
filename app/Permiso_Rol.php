<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso_Rol extends Model
{
    protected $table = 'permission_role';

    protected $fillable =[
        'permission_id',
        'role_id',
        'created_at',
        'updated_at'
    ];

}
