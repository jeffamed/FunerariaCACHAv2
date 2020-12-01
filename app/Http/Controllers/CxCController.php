<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CuentasxCobrar;
use App\MotivoFecha;

class CxCController extends Controller
{
    public function ActualizarFecha(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cxc = CuentasxCobrar::where('idCxC','=',$request->id)->first();
        $cxc->Fecha_Cobro = $request->fecha;
        $cxc->save();

        $motivo = new MotivoFecha();
        $motivo->idCxC = $request->id;
        $motivo->MotivoCambio = $request->motivo;
        $motivo->save();
    }
}
