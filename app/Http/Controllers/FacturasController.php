<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;

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
        $factura = Factura::findOrFail($request->id);
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
