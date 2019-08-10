<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contrato;
use App\FechasContrato;
use Illuminate\Support\Facades\DB;

class ContratoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $contratos = Contrato::join('servicios as s','contratos.idServicio','=','s.id')
                                -> join('clientes as c','contratos.idCliente','=','c.id')
                                -> join('empleados as e','contratos.idVendedor','=','e.id')
								-> join('fechascontratos as df','df.idContrato','=','contratos.id')
                                -> select('contratos.id','contratos.Contrato','contratos.idCliente','contratos.idVendedor','contratos.idServicio','contratos.Total',DB::raw('DATE_FORMAT(contratos.Fecha_Emision,"%d-%m-%Y") as Fecha_Emision')
                                         ,'contratos.Frecuencia_Pago','contratos.Estado','contratos.Descuento','contratos.Beneficiarios','contratos.Nota','contratos.Cuota','contratos.Numero_Frecuencia'
										 ,'contratos.SaldoR','df.id as idDocFact','df.Fecha_PropuestaP as FechaPago','df.Fecha_Cobro as FechaCobro'
                                         ,'s.Nombre as Servicio','s.id as idServicio','s.Monto as Costo','e.Nombre as NombreEmpleado','e.id as idEmpleado','c.id as idCliente',DB::raw('concat(c.Nombre, " ",c.Apellido) as NombreCliente'))
                                -> orderBy('contratos.id','desc')
                                -> paginate(7);
        }else{
            $contratos = Contrato::join('servicios as s','contratos.idServicio','=','s.id')
									-> join('clientes as c','contratos.idCliente','=','c.id')
									-> join('empleados as e','contratos.idVendedor','=','e.id')
									-> join('fechascontratos as df','df.idContrato','=','contratos.id')
									-> select('contratos.id','contratos.Contrato','contratos.idCliente','contratos.idVendedor','contratos.idServicio','contratos.Total','contratos.Fecha_Emision'
											 ,'contratos.Frecuencia_Pago','contratos.Estado','contratos.Descuento','contratos.Beneficiarios','contratos.Nota','contratos.Cuota','contratos.Numero_Frecuencia'
											 ,'contratos.SaldoR','df.id as idDocFact','df.Fecha_PropuestaP as FechaPago','df.Fecha_Cobro as FechaCobro','c.id as idCliente'
											 ,'df.id as idDocFact','df.Fecha_PropuestaP as FechaPago','df.Fecha_Cobro as FechaCobro','c.id as idCliente'
											 ,'s.Nombre as Servicio','s.id as idServicio','s.Monto as Costo','e.Nombre as NombreEmpleado','e.id as idEmpleado','c.id as idCliente',DB::raw('concat(c.Nombre, " ",c.Apellido) as NombreCliente'))
									-> where($criterio,'like','%'.$buscar.'%')
									-> orderBy('contratos.id','desc')
									-> paginate(7);
        }
         
        return[
                'pagination' => [
                    'total'         => $contratos->total(),
                    'current_page'  => $contratos->currentPage(),
                    'per_page'      => $contratos->perPage(),
                    'last_page'     => $contratos->lastPage(),
                    'from'          => $contratos->firstItem(),
                    'to'            => $contratos->lastItem(),
                ],
                'contratos'  =>  $contratos
            ];
    }

    public function seleccionar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $contratos = Contrato::join('clientes as c','contratos.idCliente','=','c.id')
                            ->where('contratos.Estado','=','Activo')
                            -> select('contratos.id','contratos.Contrato',DB::raw('concat(c.Nombre, " ",c.Apellido) as NombreCliente'),'contratos.SaldoR','contratos.Total')
                            -> orderBy('contratos.Contrato','desc')
                            -> get();
                            
        // where('Nombre','like','%'.$filtro.'%')
        return ['contratos'=>$contratos];
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            
            $contrato = new Contrato();
            $contrato->idCliente = $request->idCliente;
            $contrato->idVendedor = $request->idVendedor;
            $contrato->idServicio = $request->idServicio;
            $contrato->Contrato = $request->Contrato;
            $contrato->Total = $request->Total;
            $contrato->SaldoR = $contrato->Total;
            $contrato->Fecha_Emision = $request->Fecha_Emision;
            $contrato->Frecuencia_Pago = $request->Frecuencia_Pago;
            $contrato->Numero_Frecuencia = $request->Numero_Frecuencia;
            $contrato->Descuento = $request->Descuento;
            $contrato->Beneficiarios = $request->Beneficiarios;
            $contrato->Nota = $request->Nota;
            $contrato->Cuota = $request->Cuota;
            $contrato->Estado = 'Activo';
            $contrato->save();

            $fecha = new FechasContrato();
            $fecha->Fecha_PropuestaP = $request->Fecha_Cobro;
            $fecha->Fecha_Cobro = $fecha->Fecha_PropuestaP;
            $fecha->idContrato = $contrato->id;
            $fecha->Estado = "Por Cobrar";
            $fecha->save();

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
            $contrato = Contrato::findOrFail($request->id);
			$fecha = FechasContrato::where('idContrato','=',$contrato->id)->firstOrFail();
				
            $contrato->idCliente = $request->idCliente;
            $contrato->idVendedor = $request->idVendedor;
            $contrato->idServicio = $request->idServicio;
            $contrato->Contrato = $request->Contrato;
            $contrato->Total = $request->Total;
            $contrato->SaldoR = $contrato->Total;
            $contrato->Fecha_Emision = $request->Fecha_Emision;
            $contrato->Frecuencia_Pago = $request->Frecuencia_Pago;
            $contrato->Numero_Frecuencia = $request->Numero_Frecuencia;
            $contrato->Descuento = $request->Descuento;
            $contrato->Beneficiarios = $request->Beneficiarios;
            $contrato->Nota = $request->Nota;
            $contrato->Cuota = $request->Cuota;
            $contrato->Estado = 'Activo';
            $contrato->save();

            $fecha->Fecha_PropuestaP = $request->Fecha_Cobro;
            $fecha->Fecha_Cobro = $fecha->Fecha_PropuestaP;
            $fecha->Estado = "Por Cobrar";
            $fecha->save();

            DB::commit();
			
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
    public function suspender(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $contrato = Contrato::findOrFail($request->id);
        $contrato->Estado = 'Suspendido';
        $contrato->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $contrato = Contrato::findOrFail($request->id);
        $contrato->Estado = 'Activo';
        $contrato->save();
    }
}
