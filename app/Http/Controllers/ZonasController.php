<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zona;
use Illuminate\Support\Facades\DB;

class ZonasController extends Controller
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
            $zonas = Zona::join('empleados','zonas.idColector','=','empleados.id')
                            ->join('municipios','zonas.idMunicipio','=','municipios.id')
                            ->select('zonas.id','zonas.Nombre', DB::raw('concat(empleados.Nombre," ",empleados.Apellido) as Empleado')
									,'empleados.id as idEmpleado','municipios.Nombre as Municipio','municipios.id as idMunicipio','zonas.idMunicipio','zonas.Estado')
                            ->orderBy('zonas.id','desc')
                            ->paginate(7);
        }else{
            $zonas = Zona::join('empleados','zonas.idColector','=','empleados.id')
                            ->join('municipios','zonas.idMunicipio','=','municipios.id')
                            ->select('zonas.id','zonas.Nombre',DB::raw('concat(empleados.Nombre," ",empleados.Apellido) as Empleado'),'empleados.id as idEmpleado','municipios.Nombre as Municipio','municipios.id as idMunicipio','zonas.idMunicipio','zonas.Estado')
                            ->where('zonas.'.$criterio,'like','%'.$buscar.'%')
                            ->orderBy('zonas.id','desc')
                            ->paginate(7);
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

    public function seleccionar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $zonas = Zona::where('Estado','=','Activo')->select('id','Nombre')
                        ->orderBy('nombre','desc')->get();
        return ['zonas'=>$zonas];
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
        if (!$request->ajax()) return redirect('/');
        $zona = Zona::findOrFail($request->id);
        $zona->Nombre = $request->Nombre;
        $zona->idColector = $request->idColector;
        $zona->idMunicipio = $request->idMunicipio;
        $zona->Estado = 'Activo';
        $zona->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $zona = Zona::findOrFail($request->id);
        $zona->Estado = 'Inactivo';
        $zona->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $zona = Zona::findOrFail($request->id);
        $zona->Estado = 'Activo';
        $zona->save();
    }
}
