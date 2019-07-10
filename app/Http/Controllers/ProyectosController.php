<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;

class ProyectosController extends Controller
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
             $proyectos = Proyecto::orderBy('id','desc')->paginate(8);
         }else{
             $proyectos = Proyecto::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(8);
         }
 
         return[
             'pagination' => [
                 'total'         => $proyectos->total(),
                 'current_page'  => $proyectos->currentPage(),
                 'per_page'      => $proyectos->perPage(),
                 'last_page'     => $proyectos->lastPage(),
                 'from'          => $proyectos->firstItem(),
                 'to'            => $proyectos->lastItem(),
             ],
             'proyectos'  =>  $proyectos
         ];
    }

    public function seleccionar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $proyectos = Proyecto::where('Estado','=','Activo')->select('id','Nombre')
                        ->orderBy('nombre','desc')->get();
        return ['proyectos'=>$proyectos];
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
        $proyecto = new Proyecto();
        $proyecto->Nombre = $request->Nombre;
        $proyecto->Descripcion = $request->Descripcion;
        $proyecto->Estado = 'Activo';
        $proyecto->save();
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
        $proyecto = Proyecto::findOrFail($request->id);
        $proyecto->Nombre = $request->Nombre;
        $proyecto->Descripcion = $request->Descripcion;
        $proyecto->Estado = 'Activo';
        $proyecto->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $proyecto = Proyecto::findOrFail($request->id);
        $proyecto->Estado = 'Inactivo';
        $proyecto->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $proyecto = Proyecto::findOrFail($request->id);
        $proyecto->Estado = 'Activo';
        $proyecto->save();
    }
}
