<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contrato;

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
                                -> select('contratos.id','contratos.Contrato','contratos.idCliente','contratos.idVendedor','contratos.idServicio','contratos.Total','contratos.Fecha_Emision'
                                         ,'contratos.Frecuencia_Pago','contratos.Estado','contratos.Descuento','contratos.Beneficiarios','contratos.Nota','contratos.Cuota','contratos.Numero_Frecuencia'
                                         ,'s.Nombre as Servicio','s.id as idServicio','s.Monto as Costo','e.Nombre as NombreEmpleado','e.id as idEmpleado','c.id as idCliente','c.Nombre as NombreCliente')
                                -> orderBy('contratos.id','desc')
                                -> paginate(7);
        }else{
            $contratos = Contrato::join('servicios as s','contratos.idServicio','s.id')
                                -> join('clientes as c','contratos.idCliente','c.id')
                                -> join('empleados as e','contratos.idVendedor','e.id')
                                -> select('contratos.id','contratos.Contrato','contratos.idCliente','contratos.idVendedor','contratos.idServicio','contratos.Total','contratos.Fecha_Emision'
                                         ,'contratos.Frecuencia_Pago','contratos.Estado','contratos.Descuento','contratos.Beneficiarios','contratos.Nota','contratos.Cuota','contratos.Numero_Frecuencia'
                                         ,'s.Nombre as Servicio','s.id as idServicio','s.Monto as Costo','e.Nombre as NombreEmpleado','e.id as idEmpleado'
                                         ,'c.id as idCliente','c.Nombre as NombreCliente')
                                -> where('contratos.'.$criterio,'like','%'.$buscar.'%')
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

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $contrato = new Contrato();
        $contrato->idCliente = $request->idCliente;
        $contrato->idVendedor = $request->idVendedor;
        $contrato->idServicio = $request->idServicio;
        $contrato->Contrato = $request->Contrato;
        $contrato->Total = $request->Total;
        $contrato->Fecha_Emision = $request->Fecha_Emision;
        // $contrato->Fecha_Pago = $request->Fecha_Pago;
        $contrato->Frecuencia_Pago = $request->Frecuencia_Pago;
        $contrato->Numero_Frecuencia = $request->Numero_Frecuencia;
        $contrato->Descuento = $request->Descuento;
        $contrato->Beneficiarios = $request->Beneficiarios;
        $contrato->Nota = $request->Nota;
        $contrato->Cuota = $request->Cuota;
        $contrato->Estado = 'Activo';
        $contrato->save();
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
        $contrato = Contrato::findOrFail($request->id);
        $contrato->idCliente = $request->idCliente;
        $contrato->idVendedor = $request->idVendedor;
        $contrato->idServicio = $request->idServicio;
        $contrato->Contrato = $request->Contrato;
        $contrato->Total = $request->Total;
        $contrato->Fecha_Emision = $request->Fecha_Emision;
        // $contrato->Fecha_Pago = $request->Fecha_Pago;
        $contrato->Frecuencia_Pago = $request->Frecuencia_Pago;
        $contrato->Numero_Frecuencia = $request->Numero_Frecuencia;
        $contrato->Descuento = $request->Descuento;
        $contrato->Beneficiarios = $request->Beneficiarios;
        $contrato->Nota = $request->Nota;
        $contrato->Cuota = $request->Cuota;
        $contrato->Estado = 'Activo';
        $contrato->save();
    }
}
