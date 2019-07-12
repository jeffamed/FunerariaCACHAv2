<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio;

class ServiciosController extends Controller
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
            $servicios = Servicio::join('proyectos','servicios.idProyecto','=','proyectos.id')
                                    ->select('servicios.id','servicios.Nombre','servicios.Monto','servicios.Descripcion','proyectos.Nombre as Proyecto','proyectos.id as idProyecto','servicios.Estado')
                                    ->orderBy('servicios.id','desc')
                                    ->paginate(7);
        }else{
            $servicios = Servicio::join('proyectos','servicios.idProyecto','=','proyectos.id')
                                    ->select('servicios.id','servicios.Nombre','servicios.Monto','servicios.Descripcion','proyectos.Nombre as Proyecto','proyectos.id as idProyecto','servicios.Estado')
                                    ->where('servicios.'.$criterio,'like','%'.$buscar.'%')
                                    ->orderBy('servicios.id','desc')
                                    ->paginate(7);
        }

        return[
            'pagination' => [
                'total'         => $servicios->total(),
                'current_page'  => $servicios->currentPage(),
                'per_page'      => $servicios->perPage(),
                'last_page'     => $servicios->lastPage(),
                'from'          => $servicios->firstItem(),
                'to'            => $servicios->lastItem(),
            ],
            'servicios'  =>  $servicios
        ];
    }

    public function seleccionar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicios = Servicio::where('Estado','=','Activo')
                            -> select('id','Nombre','Monto')
                            -> orderBy('Nombre','desc')->get();
        return ['servicios'=>$servicios];
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
        $servicio = new Servicio();
        $servicio->idProyecto = $request->idProyecto;
        $servicio->Nombre = $request->Nombre;
        $servicio->Descripcion = $request->Descripcion;
        $servicio->Monto = $request->Monto;
        $servicio->Estado = 'Activo';
        $servicio->save();
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
        $servicio = Servicio::findOrFail($request->id);
        $servicio->idProyecto = $request->idProyecto;
        $servicio->Nombre = $request->Nombre;
        $servicio->Descripcion = $request->Descripcion;
        $servicio->Monto = $request->Monto;
        $servicio->Estado = 'Activo';
        $servicio->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicio = Servicio::findOrFail($request->id);
        $servicio->Estado = 'Inactivo';
        $servicio->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicio = Servicio::findOrFail($request->id);
        $servicio->Estado = 'Activo';
        $servicio->save();
    }
}
