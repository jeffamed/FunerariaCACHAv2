<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FechasFinanciamiento;
use App\Financiamiento;

class FinanciamientoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $financiamientos = Financiamiento::join('servicios as s','financiamientos.idServicio','=','s.id')
                                -> join('clientes as c','financiamientos.idCliente','=','c.id')
                                -> join('empleados as e','financiamientos.idVendedor','=','e.id')
								-> join('fechasfinanciamientos as df','df.idfinanciamiento','=','financiamientos.id')
                                -> select('financiamientos.id','financiamientos.financiamiento','financiamientos.idCliente','financiamientos.idVendedor','financiamientos.idServicio','financiamientos.Total','financiamientos.Fecha_Emision'
                                         ,'financiamientos.Frecuencia_Pago','financiamientos.Estado','financiamientos.Descuento','financiamientos.Beneficiarios','financiamientos.Nota','financiamientos.Cuota','financiamientos.Numero_Frecuencia'
										 ,'df.id as idDocFact','df.Fecha_PropuestaP as FechaPago','df.Fecha_Cobro as FechaCobro'
                                         ,'s.Nombre as Servicio','s.id as idServicio','s.Monto as Costo','e.Nombre as NombreEmpleado','e.id as idEmpleado','c.id as idCliente',DB::raw('concat(c.Nombre, " ",c.Apellido) as NombreCliente'))
                                -> orderBy('financiamientos.id','desc')
                                -> paginate(7);
        }else{
			 if($criterio == 'financiamiento'){
				$financiamientos = Financiamiento::join('servicios as s','financiamientos.idServicio','s.id')
									-> join('clientes as c','financiamientos.idCliente','c.id')
									-> join('empleados as e','financiamientos.idVendedor','e.id')
									-> join('fechasfinanciamientos as df','df.idfinanciamiento','=','financiamientos.id')
									-> select('financiamientos.id','financiamientos.financiamiento','financiamientos.idCliente','financiamientos.idVendedor','financiamientos.idServicio','financiamientos.Total','financiamientos.Fecha_Emision'
											 ,'financiamientos.Frecuencia_Pago','financiamientos.Estado','financiamientos.Descuento','financiamientos.Beneficiarios','financiamientos.Nota','financiamientos.Cuota','financiamientos.Numero_Frecuencia'
											 ,'s.Nombre as Servicio','s.id as idServicio','s.Monto as Costo','e.Nombre as NombreEmpleado','e.id as idEmpleado'
											 ,'df.id as idDocFact','df.Fecha_PropuestaP as FechaPago','df.Fecha_Cobro as FechaCobro','c.id as idCliente','c.Nombre as NombreCliente')
									-> where('financiamientos.'.$criterio,'like','%'.$buscar.'%')
									-> orderBy('financiamientos.id','desc')
									-> paginate(7);
			 }else{
				 $financiamientos = Financiamiento::join('servicios as s','financiamientos.idServicio','s.id')
									-> join('clientes as c','financiamientos.idCliente','c.id')
									-> join('empleados as e','financiamientos.idVendedor','e.id')
									-> join('fechasfinanciamientos as df','df.idfinanciamiento','=','financiamientos.id')
									-> select('financiamientos.id','financiamientos.financiamiento','financiamientos.idCliente','financiamientos.idVendedor','financiamientos.idServicio','financiamientos.Total','financiamientos.Fecha_Emision'
											 ,'financiamientos.Frecuencia_Pago','financiamientos.Estado','financiamientos.Descuento','financiamientos.Beneficiarios','financiamientos.Nota','financiamientos.Cuota','financiamientos.Numero_Frecuencia'
											 ,'s.Nombre as Servicio','s.id as idServicio','s.Monto as Costo','e.Nombre as NombreEmpleado','e.id as idEmpleado'
											 ,'df.id as idDocFact','df.Fecha_PropuestaP as FechaPago','df.Fecha_Cobro as FechaCobro','c.id as idCliente','c.Nombre as NombreCliente')
									-> where('c.'.$criterio,'like','%'.$buscar.'%')
									-> orderBy('financiamientos.id','desc')
									-> paginate(7);
			 }
            
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
            $financiamiento->idCliente = $request->idCliente;
            $financiamiento->idVendedor = $request->idVendedor;
            $financiamiento->idServicio = $request->idServicio;
            $financiamiento->financiamiento = $request->financiamiento;
            $financiamiento->Total = $request->Total;
            $financiamiento->Fecha_Emision = $request->Fecha_Emision;
            $financiamiento->Frecuencia_Pago = $request->Frecuencia_Pago;
            $financiamiento->Numero_Frecuencia = $request->Numero_Frecuencia;
            $financiamiento->Descuento = $request->Descuento;
            $financiamiento->Beneficiarios = $request->Beneficiarios;
            $financiamiento->Nota = $request->Nota;
            $financiamiento->Cuota = $request->Cuota;
            $financiamiento->Estado = 'Activo';
            $financiamiento->save();

            $fecha = new FechasFinanciamiento();
            $fecha->Fecha_PropuestaP = $request->Fecha_Cobro;
            $fecha->Fecha_Cobro = $fecha->Fecha_PropuestaP;
            $fecha->idfinanciamiento = $financiamiento->id;
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
            $financiamiento = financiamiento::findOrFail($request->id);
			$fecha = FechasFinanciamiento::where('idFinanciamiento','=',$financiamiento->id)->firstOrFail();
				
            $financiamiento->idCliente = $request->idCliente;
            $financiamiento->idVendedor = $request->idVendedor;
            $financiamiento->idServicio = $request->idServicio;
            $financiamiento->financiamiento = $request->financiamiento;
            $financiamiento->Total = $request->Total;
            $financiamiento->Fecha_Emision = $request->Fecha_Emision;
            $financiamiento->Frecuencia_Pago = $request->Frecuencia_Pago;
            $financiamiento->Numero_Frecuencia = $request->Numero_Frecuencia;
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
}
