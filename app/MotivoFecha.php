<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MotivoFecha extends Model
{
    protected $table = "motivofecha";

    protected $fillable = [
        'id',
        'idCxC',
        'MotivoCambio',
        'created_at',
        'updated_at'
    ];
}
