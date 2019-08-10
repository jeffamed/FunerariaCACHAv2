<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\Contrato;
use App\Financiamiento;
use Illuminate\Support\Facades\DB;

class FacturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $facturas = Factura::orderBy('id','desc')->paginate(7);
        }else{
            $facturas = Factura::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(7);
        }

        return[
            'pagination' => [
                'total'         => $facturas->total(),
                'current_page'  => $facturas->currentPage(),
                'per_page'      => $facturas->perPage(),
                'last_page'     => $facturas->lastPage(),
                'from'          => $facturas->firstItem(),
                'to'            => $facturas->lastItem(),
            ],
            'facturas'  =>  $facturas
        ];
    }

    public function InfoDocumento(Request $request){
        $tipoDoc = $request->tipoDocumento;
        $buscarDoc = $request->numeroDoc;

        if($tipoDoc == 'Contrato'){
            $informacion = Contrato::join('clientes as cl','contratos.idCliente','=','cl.id')
                               ->select(DB::raw('concat(cl.Nombre," ",cl.Apellido) as Cliente'),'contratos.cuota','contratos.Total','contratos.SaldoR')
                               ->where('contratos.Contrato','=',$buscarDoc)
                               ->where('contratos.Estado','Activo')
                               ->first();
        }else{
            $informacion = Financiamiento::join('contratos as c','financiamientos.idContrato','=','c.id')
                                        -> join('clientes as cl','c.idCliente','=','cl.id')
                                        -> select(DB::raw('concat(cl.Nombre," ",cl.Apellido) as Cliente'),'financiamientos.cuota','financiamientos.Total','financiamientos.SaldoR')
                                        -> where('financiamientos.Financiamiento','=',$buscarDoc)
                                        -> where('financiamientos.Estado','Activo')
                                        -> first();
        }
        
        return ["informacion"=>$informacion];
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
        $factura = new Factura();
        $factura->idDolar =  $request->idDolar;
        $factura->idDocumento = $request->idDocumento;
        $factura->TipoDocumento = $request->TipoDocumento;
        $factura->Monto = $request->Monto;
        $factura->Estado = 'Activo';
        $factura->save();
    }

    public function anular(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $factura = Factura::findOrFail($request->id);
        $factura->Estado = 'Anular';
        $factura->save();
    }
}
