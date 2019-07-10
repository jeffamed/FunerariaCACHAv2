<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;

class ClientesController extends Controller
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
            $clientes = Cliente::join('barrios as b','clientes.idBarrio','=','b.id')
                                ->select('b.id as idBarrio','b.Nombre as Barrio','clientes.id','clientes.Nombre','clientes.Apellido','clientes.Direccion','clientes.Cedula','clientes.Estado_Civil','clientes.Telefono','clientes.Estado')
                                ->orderBy('id','desc')
                                ->paginate(8);
        }else{
            $clientes = Cliente::join('barrios as b','clientes.idBarrio','=','b.id')
                                ->select('b.id as idBarrio','b.Nombre as Barrio','clientes.id','clientes.Nombre','clientes.Apellido','clientes.Direccion','clientes.Cedula','clientes.Estado_Civil','clientes.Telefono','clientes.Estado')
                                ->where('clientes.'.$criterio,'like','%'.$buscar.'%')
                                ->orderBy('id','desc')
                                ->paginate(8);
        }

        return[
            'pagination' => [
                'total'         => $clientes->total(),
                'current_page'  => $clientes->currentPage(),
                'per_page'      => $clientes->perPage(),
                'last_page'     => $clientes->lastPage(),
                'from'          => $clientes->firstItem(),
                'to'            => $clientes->lastItem(),
            ],
            'clientes'  =>  $clientes
        ];
    }

    public function seleccionar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $clientes = Cliente::select('id','Nombre')->orderBy('nombre','desc')->get();
        return ['clientes'=>$clientes];
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
        $cliente = new Cliente();
        $cliente->idBarrio = $request->idBarrio;
        $cliente->Nombre = $request->Nombre;
        $cliente->Apellido = $request->Apellido;
        $cliente->Direccion = $request->Direccion;
        $cliente->Estado_Civil = $request->Estado_Civil;
        $cliente->Telefono = $request->Telefono;
        $cliente->Cedula = $request->Cedula;
        $cliente->Estado = 'Tipo A';
        $cliente->save();
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
        $cliente = Cliente::findOrFail($request->id);
        $cliente->idBarrio = $request->idBarrio;
        $cliente->Nombre = $request->Nombre;
        $cliente->Apellido = $request->Apellido;
        $cliente->Direccion = $request->Direccion;
        $cliente->Estado_Civil = $request->Estado_Civil;
        $cliente->Telefono = $request->Telefono;
        $cliente->Cedula = $request->Cedula;
        $cliente->Estado = 'Tipo A';
        $cliente->save();
    }

}
