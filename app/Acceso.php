<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    protected $table = "users";

    protected $fillable = [
        'id', 
        'idEmpleado', 
        'name',
        'password',
        'state'
    ];

    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
