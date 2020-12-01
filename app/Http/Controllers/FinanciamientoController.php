<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FechasFinanciamiento;
use App\Financiamiento;
use App\CuentasxCobrar;
use Illuminate\Support\Facades\DB;

class FinanciamientoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $financiamientos = Financiamiento::join('contratos as c','financiamientos.idContrato','=','c.id')
                                -> join('clientes as cl','c.idCliente','=','cl.id')
                                -> select('financiamientos.id','financiamientos.idContrato','financiamientos.Financiamiento','financiamientos.PorcentajeFin','financiamientos.SubTotal'
                                         ,'financiamientos.Total', DB::raw('FORMAT(financiamientos.Total, 2) as Totales'),'financiamientos.Frecuencia_Pago','financiamientos.numero_Frec','financiamientos.Cuota','financiamientos.Estado'
                                         ,'c.id as idContrato','c.Contrato',DB::raw('concat(cl.Nombre," ",cl.Apellido) as Cliente'))
                                -> orderBy('financiamientos.id','desc')
                                -> paginate(7);
        }else{
				$financiamientos = Financiamiento::join('contratos as c','financiamientos.idContrato','=','c.id')
                                    -> join('clientes as cl','c.idCliente','=','cl.id')
                                    -> select('financiamientos.id','financiamientos.idContrato','financiamientos.Financiamiento','financiamientos.PorcentajeFin','financiamientos.SubTotal'
                                            ,'financiamientos.Total','financiamientos.Frecuencia_Pago','financiamientos.numero_Frec','financiamientos.Cuota','financiamientos.Estado'
                                            ,'c.id as idContrato','c.Contrato',DB::raw('concat(cl.Nombre," ",cl.Apellido) as Cliente'))
									-> where($criterio,'like','%'.$buscar.'%')
									-> orderBy('financiamientos.id','desc')
									-> paginate(7);
        }
         
        return[
                'pagination' => [
                    'total'         => $financiamientos->total(),
                    'current_page'  => $financiamientos->currentPage(),
                    'per_page'      => $financiamientos->perPage(),
                    'last_page'     => $financiamientos->lastPage(),
                    'from'          => $financiamientos->firstItem(),
                    'to'            => $financiamientos->lastItem(),
                ],
                'financiamientos'  =>  $financiamientos
            ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            
            $financiamiento = new Financiamiento();
            $financiamiento->idContrato = $request->idContrato;
            $financiamiento->Financiamiento = $request->financiamiento;
            $financiamiento->PorcentajeFin = $request->PorcentajeFin;
            $financiamiento->Total = $request->Total;
            $financiamiento->subTotal = $request->subTotal;
            $financiamiento->Frecuencia_Pago = $request->Frecuencia_Pago;
            $financiamiento->numero_Frec = $request->Numero_Frecuencia;
            $financiamiento->Cuota = $request->Cuota;
            $financiamiento->SaldoR = $request->Total;
            $financiamiento->Estado = 'Activo';
            $financiamiento->save();

            $cxc = new CuentasxCobrar();
            $cxc->idDocumento = $financiamiento->id;
            $cxc->FechaPropuestaP = $request->Fecha_Cobro;
            $cxc->Fecha_Cobro = $request->Fecha_Cobro;
            $cxc->Estado = "Por Cobrar";
            $cxc->Total = $request->Total;
            $cxc->TotalRestante = $request->Total;
            $cxc->Tipo_Doc = 'Financiamiento';
            $cxc->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $financiamiento = Financiamiento::findOrFail($request->id);
			$fecha = FechasFinanciamiento::where('idFinanciamiento','=',$financiamiento->id)->firstOrFail();
				
            $financiamiento->financiamiento = $request->financiamiento;
            $financiamiento->Total = $request->Total;
            $financiamiento->Fecha_Emision = $request->Fecha_Emision;
            $financiamiento->Frecuencia_Pago = $request->Frecuencia_Pago;
            $financiamiento->numero_Frec = $request->Numero_Frecuencia;
            $financiamiento->Descuento = $request->Descuento;
            $financiamiento->Beneficiarios = $request->Beneficiarios;
            $financiamiento->Nota = $request->Nota;
            $financiamiento->Cuota = $request->Cuota;
            $financiamiento->Estado = 'Activo';
            $financiamiento->save();

            $fecha->Fecha_PropuestaP = $request->Fecha_Cobro;
            $fecha->Fecha_Cobro = $fecha->Fecha_PropuestaP;
            $fecha->Estado = "Por Cobrar";
            $fecha->save();

            DB::commit();
			
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
    public function informacion(Request $request)
    {
        $id = $request->idFin;
        $info = DB::select('call sp_CargarFinanciamiento(?)',[$id]);

        return ['informacion'=>$info];
    }
}
