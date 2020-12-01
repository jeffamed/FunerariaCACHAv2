<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentasxCobrar extends Model
{
    protected $table = "cuentas_x_cobrar";

    protected $primaryKey = 'idCxC';

    protected $fillable = ['idCxC','idDocumento','FechaPropuestaP','Fecha_Cobro','Estado','Total','Tipo_Doc','TotalRestante'];

    public function contrato()
    {
        return $this->belongsTo('App\Contrato');
    }

    public function financiamiento()
    {
        return $this->belongsTo('App\Financiamiento');
    }
}
