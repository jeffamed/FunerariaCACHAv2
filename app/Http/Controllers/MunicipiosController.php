<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Municipio;

class MunicipiosController extends Controller
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
            $municipios = Municipio::join('departamentos','municipios.idDepartamento','departamentos.id')
                                    ->select('municipios.Nombre','departamentos.Nombre as Departamento','municipios.Estado')
                                    ->orderBy('id','desc')
                                    ->paginate(5);
        }else{
            $municipios = Municipio::join('departamentos','municipios.idDepartamento','departamentos.id')
                                    ->select('municipios.Nombre','departamentos.Nombre as Departamento','municipios.Estado')
                                    ->orderBy('id','desc')
                                    ->where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')
                                    ->paginate(5);
        }

        return[
            'pagination' => [
                'total'         => $municipios->total(),
                'current_page'  => $municipios->currentPage(),
                'per_page'      => $municipios->perPage(),
                'last_page'     => $municipios->lastPage(),
                'from'          => $municipios->firstItem(),
                'to'            => $municipios->lastItem(),
            ],
            'municipios'  =>  $municipios
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
        $municipio = new Municipio();
        $municipio->Nombre = $request->Nombre;
        $municipio->Estado = 'Activo';
        $municipio->save();
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
        $municipio = Municipio::findOrFail($request->id);
        $municipio->Nombre = $request->Nombre;
        $municipio->Estado = 'Activo';
        $municipio->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $municipio = Municipio::findOrFail($request->id);
        // $municipio = municipio::findOrFail($id); 
        $municipio->Estado = 'Inactivo';
        $municipio->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $municipio = Municipio::findOrFail($request->id);
        // $municipio = municipio::findOrFail($id);
        $municipio->Estado = 'Activo';
        $municipio->save();
    }
}
