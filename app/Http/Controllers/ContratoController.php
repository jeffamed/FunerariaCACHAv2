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
                $contratos = Contrato::join('servicios as s','contratos.idServicio','s.id')
                                    -> join('clientes as c','contratos.idCliente','c.id')
                                    -> join('empleados as e','contratos.idEmpleado','e.id')
                                    -> select('contratos.id','contratos.Contrato','contratos.idCliente','contratos.idVendedor','contratos.idServicios','contratos.Total','contratos.Fecha_Emision'
                                             ,'contratos.Frecuencia_Pago','contratos.Estado','contratos.Descuento','contratos.Beneficiarios','contratos.Nota','contratos.Cuota'
                                             ,'s.Nombre as Servicio','s.id as idServicio','s.monto as Costo','concat(e.Nombre, " ", e.Apellido) as NombreEmpleado','e.id as idEmpleado'
                                             ,'c.id as idCliente','concat(c.Nombre, " ", c.Apellido) as NombreCliente')
                                    -> orderBy('id','desc')
                                    -> paginate(7);
            }else{
                $contratos = Contrato::join('servicios as s','contratos.idServicio','s.id')
                                    -> join('clientes as c','contratos.idCliente','c.id')
                                    -> join('empleados as e','contratos.idEmpleado','e.id')
                                    -> select('contratos.id','contratos.idCliente','contratos.idVendedor','contratos.idServicios','contratos.Total','contratos.Fecha_Emision'
                                             ,'contratos.Frecuencia_Pago','contratos.Estado','contratos.Descuento','contratos.Beneficiarios','contratos.Nota','contratos.Cuota'
                                             ,'s.Nombre as Servicio','s.id as idServicio','s.monto as Costo','concat(e.Nombre, " ", e.Apellido) as NombreEmpleado','e.id as idEmpleado'
                                             , 'c.id as idCliente','concat(c.Nombre, " ", c.Apellido) as NombreCliente')
                                    -> where($criterio,'like','%'.$buscar.'%')
                                    -> orderBy('id','desc')
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
}
