<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contrato;
use App\FechasContrato;
use Illuminate\Support\Facades\DB;
use App\CuentasxCobrar;
use Carbon\Carbon;

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
                                -> leftjoin('cuentas_x_cobrar as cc','contratos.id','=','cc.idDocumento')
                                -> select('contratos.id','contratos.Contrato','contratos.idCliente','contratos.idVendedor','contratos.idServicio','contratos.Total','contratos.Fecha_Emision'
                                         ,'contratos.Frecuencia_Pago','contratos.Estado','contratos.Descuento','contratos.Beneficiarios','contratos.Nota','contratos.Cuota','contratos.Numero_Frecuencia','cc.Fecha_Cobro'
										 ,'contratos.SaldoR','s.Nombre as Servicio','s.id as idServicio','s.Monto as Costo','e.Nombre as NombreEmpleado','e.id as idEmpleado','c.id as idCliente','cc.Total as Deuda','contratos.cancelado',
                                         DB::raw('concat(c.Nombre, " ",c.Apellido) as NombreCliente, Format(cc.Total,2) as TotalMoney'))
                                -> orderBy('contratos.id','desc')
                                -> paginate(9);
        }else{
            $contratos = Contrato::join('servicios as s','contratos.idServicio','=','s.id')
									-> join('clientes as c','contratos.idCliente','=','c.id')
									-> join('empleados as e','contratos.idVendedor','=','e.id')
									-> leftjoin('cuentas_x_cobrar as cc','contratos.id','=','cc.idDocumento')
									-> select('contratos.id','contratos.Contrato','contratos.idCliente','contratos.idVendedor','contratos.idServicio','contratos.Total','contratos.Fecha_Emision'
											 ,'contratos.Frecuencia_Pago','contratos.Estado','contratos.Descuento','contratos.Beneficiarios','contratos.Nota','contratos.Cuota','contratos.Numero_Frecuencia','cc.Fecha_Cobro'
                                             ,'contratos.SaldoR','c.id as idCliente','s.Nombre as Servicio','s.id as idServicio','s.Monto as Costo','e.Nombre as NombreEmpleado','e.id as idEmpleado','cc.Total as Deuda','contratos.cancelado',
                                             'c.id as idCliente',DB::raw('concat(c.Nombre, " ",c.Apellido) as NombreCliente, Format(cc.Total,2) as TotalMoney'))
									-> where($criterio,'like','%'.$buscar.'%')
									-> orderBy('contratos.id','desc')
									-> paginate(9);
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
         if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $contratos = Contrato::join('clientes as c','contratos.idCliente','=','c.id')
                            ->join('cuentas_x_cobrar as cc','contratos.id','=','cc.idDocumento')
                            ->join('servicios as s','s.id','=','contratos.idServicio')
                            ->where([['contratos.Estado','=','Activo'],['cc.Tipo_Doc','=','Contrato']])
                            ->select('contratos.id','contratos.Contrato',DB::raw('concat(c.Nombre, " ",c.Apellido) as NombreCliente'),'cc.Total as SaldoR','contratos.total','s.Monto')
                            ->orderBy('contratos.Contrato','desc')
                            ->get();
                            
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
            $contrato->cancelado = $request->Cancelado;
            $contrato->save();

            if($request->Cancelado == 'SI'){
                $cxc = new CuentasxCobrar();
                $cxc->idDocumento = $contrato->id;
                $cxc->FechaPropuestaP = $request->Fecha_Cobro;
                $cxc->Fecha_Cobro = $request->Fecha_Cobro;
                $cxc->Estado = "Por Cobrar";
                $cxc->Total = $request->Total;
                $cxc->TotalRestante = $request->Total;
                $cxc->Tipo_Doc = "Contrato";
                $cxc->save();
            }

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
            $contrato->cancelado = $request->Cancelado;
            $contrato->save();

            if($contrato->cancelado == 'SI'){
                $idbusq = CuentasxCobrar::select('idDocumento')->where([['idDocumento','=',$contrato->id],['Tipo_Doc','=','Contrato']])->first();
                if($idbusq == $request->id){
                    $fecha = CuentasxCobrar::where('idDocumento','=',$contrato->id)->firstOrFail();
                    $fecha->FechaPropuestaP = $request->Fecha_Cobro;
                    $fecha->Fecha_Cobro = $request->Fecha_Cobro;
                    $fecha->Estado = "Por Cobrar";
                    $fecha->save();
                }else if($contrato->cancelado == 'NO'){
                    $cxc = new CuentasxCobrar();
                    $cxc->idDocumento = $contrato->id;
                    $cxc->FechaPropuestaP = $request->Fecha_Cobro;
                    $cxc->Fecha_Cobro = $request->Fecha_Cobro;
                    $cxc->Estado = "Por Cobrar";
                    $cxc->Total = $request->Total;
                    $cxc->TotalRestante = $request->Total;
                    $cxc->Tipo_Doc = "Contrato";
                    $cxc->save();
                }
            }

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

    public function informacion(Request $request)
    {
        $id = $request->idContrato;
        $info = DB::select('call sp_CargarContrato(?)',[$id]);

        return ['informacion'=>$info];
    }
    public function FechaSistema()
    {
        $fecha = Carbon::now();
        $hoy = $fecha->format('Y-m-d');
        return ['fecha'=>$hoy];
    }
}
