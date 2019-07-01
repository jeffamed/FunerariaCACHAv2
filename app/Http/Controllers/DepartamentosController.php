<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Http\Requests\DepartamentoRequest;

class DepartamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  SE ESTA UTILIZANDO ELOQUENT
    public function index(Request $request)
    {
        // Llamar todos los registros
        //    $departamentos = Departamento::all();
        // con eloquent
        // Con QueryBuilder
        // $departamentos=DB::table('departamentos')->paginate(2);
        // if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar == ''){
            $departamentos = Departamento::orderBy('id','desc')->paginate(5);
        }else{
            $departamentos = Departamento::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
        }

        return[
            'pagination' => [
                'total'         => $departamentos->total(),
                'current_page'  => $departamentos->currentPage(),
                'per_page'      => $departamentos->perPage(),
                'last_page'     => $departamentos->lastPage(),
                'from'          => $departamentos->firstItem(),
                'to'            => $departamentos->lastItem(),
            ],
            'departamentos'  =>  $departamentos
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartamentoRequest $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $departamento = new Departamento();
        $departamento->Nombre = $request->Nombre;
        $departamento->Estado = 'Activo';
        $departamento->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartamentoRequest $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $departamento = Departamento::findOrFail($request->id);
        $departamento->Nombre = $request->Nombre;
        $departamento->Estado = 'Activo';
        $departamento->save();
    }

    public function desactivar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $departamento = Departamento::findOrFail($request->id);
        // $departamento = Departamento::findOrFail($id); 
        $departamento->Estado = 'Inactivo';
        $departamento->save();
    }

    public function activar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $departamento = Departamento::findOrFail($request->id);
        // $departamento = Departamento::findOrFail($id);
        $departamento->Estado = 'Activo';
        $departamento->save();
    }
}
