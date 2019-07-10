<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barrio;

class BarriosController extends Controller
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
            $barrios = Barrio::join('zonas','barrios.idZona','=','zonas.id')
                                    ->select('barrios.id','barrios.Nombre','zonas.Nombre as Zona','zonas.id as idZona')
                                    ->orderBy('barrios.id','desc')
                                    ->paginate(7);
        }else{
            $barrios = Barrio::join('zonas','barrios.idZona','=','zonas.id')
                                    ->select('barrios.id','barrios.Nombre','zonas.Nombre as Zona','zonas.id as idZona')
                                    ->where('barrios.'.$criterio,'like','%'.$buscar.'%')
                                    ->orderBy('barrios.id','desc')
                                    ->paginate(7);
        }

        return[
            'pagination' => [
                'total'         => $barrios->total(),
                'current_page'  => $barrios->currentPage(),
                'per_page'      => $barrios->perPage(),
                'last_page'     => $barrios->lastPage(),
                'from'          => $barrios->firstItem(),
                'to'            => $barrios->lastItem(),
            ],
            'barrios'  =>  $barrios
        ];
    }

    public function seleccionar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $barrios = Barrio::select('id','Nombre')->orderBy('nombre','desc')->get();
        return ['barrios'=>$barrios];
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
        $barrio = new Barrio();
        $barrio->Nombre = $request->Nombre;
        $barrio->idZona = $request->idZona;
        $barrio->save();
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
        $barrio = Barrio::findOrFail($request->id);
        $barrio->Nombre = $request->Nombre;
        $barrio->idZona = $request->idZona;
        $barrio->save();
    }

}
