<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento_Factura extends Model
{
    protected $table = 'documentos_facturas';

    protected $fillable = [
        'id',
        'idDocumento',
        'Fecha_PropuestaP',
        'Fecha_Cobro',
        'Estado'
    ];
	public function contrato()
    {
        return $this->belongsTo('App\Contrato');
    }
}
