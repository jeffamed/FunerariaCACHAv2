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
    public function index()
    {
       $departamentos = Departamento::all();
       return $departamentos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartamentoRequest $request)
    {
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
    public function update(DepartamentoRequest $request, $id)
    {
        // $departamento = Departamento::findOrFail($request->$id);
        $departamento = Departamento::findOrFail($id);
        $departamento->Nombre = $request->Nombre;
        $departamento->Estado = 'Activo';
        $departamento->save();
    }

    public function desactivar(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->Estado = 'Inactivo';
        $departamento->save();
    }

    public function activar(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->Estado = 'Activo';
        $departamento->save();
    }
}
