<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zona;

class ZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $zonas = Zona::join('empleados','zonas.idColector','=','empleados.id')
                            ->join('municipios','zonas.idMunicipio','=','municipios.id')
                            ->select('zonas.id','zonas.Nombre','empleados.Nombre as Empleado','empleados.id as idEmpleado','municipios.Nombre as Municipio','municipios.id as idMunicipio','zonas.idMunicipio','zonas.Estado')
                            ->orderBy('zonas.id','desc')
                            ->paginate(5);
        }else{
            $zonas = Zona::join('empleados','zonas.idColector','=','empleados.id')
                            ->join('municipios','zonas.idMunicipio','=','municipios.id')
                            ->select('zonas.id','zonas.Nombre','empleados.Nombre as Empleado','empleados.id as idEmpleado','municipios.Nombre as Municipio','municipios.id as idMunicipio','zonas.idMunicipio','zonas.Estado')
                            ->where('zonas.'.$criterio,'like','%'.$buscar.'%')
                            ->orderBy('zonas.id','desc')
                            ->paginate(5);
        }

        return[
            'pagination' => [
                'total'         => $zonas->total(),
                'current_page'  => $zonas->currentPage(),
                'per_page'      => $zonas->perPage(),
                'last_page'     => $zonas->lastPage(),
                'from'          => $zonas->firstItem(),
                'to'            => $zonas->lastItem(),
            ],
            'zonas'  =>  $zonas
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
        // if (!$request->ajax()) return redirect('/');
        $zona = new Zona();
        $zona->Nombre = $request->Nombre;
        $zona->idColector = $request->idColector;
        $zona->idMunicipio = $request->idMunicipio;
        $zona->Estado = 'Activo';
        $zona->save();
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
        // if (!$request->ajax()) return redirect('/');
        $zona = Zona::findOrFail($request->id);
        $zona->Nombre = $request->Nombre;
        $zona->idColector = $request->idColector;
        $zona->idMunicipio = $request->idMunicipio;
        $zona->Estado = 'Activo';
        $zona->save();
    }

    public function desactivar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $zona = Zona::findOrFail($request->id);
        $zona->Estado = 'Inactivo';
        $zona->save();
    }

    public function activar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $zona = Zona::findOrFail($request->id);
        $zona->Estado = 'Activo';
        $zona->save();
    }
}
