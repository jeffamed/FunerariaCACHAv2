<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TasaCambio;

class TasaCambiosController extends Controller
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
            $cambios = TasaCambio::orderBy('id','desc')
                                    ->paginate(9);
        }else{
            $cambios = TasaCambio::where('Monto','like','%'.$buscar.'%')
                                    ->orderBy('id','desc')
                                    ->paginate(9);
        }

        return[
            'pagination' => [
                'total'         => $cambios->total(),
                'current_page'  => $cambios->currentPage(),
                'per_page'      => $cambios->perPage(),
                'last_page'     => $cambios->lastPage(),
                'from'          => $cambios->firstItem(),
                'to'            => $cambios->lastItem(),
            ],
            'cambios'  =>  $cambios
        ];
    }

    public function mostrar()
    {
        $tasa = TasaCambio::orderBy('id','desc')->first();

        return ["tasa"=>$tasa];
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
        $cambio = new TasaCambio();
        $cambio->Monto = $request->Monto;
        $cambio->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $cambio = TasaCambio::findOrFail($request->id);
        $cambio->Monto = $request->Monto;
        $cambio->save();
    }

}
