<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Acceso;

class AccesoController extends Controller
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
            $accesos = Acceso::join('empleados','accesos.idEmpleado','=','empleados.id')
                                    ->select('accesos.id','accesos.Usuario','empleados.Nombre as Empleado','empleados.id as idEmpleado','accesos.idEmpleado','accesos.password','accesos.Rol','accesos.Estado')
                                    ->orderBy('accesos.id','desc')
                                    ->paginate(7);
        }else{
            $accesos = Acceso::join('empleados','accesos.idEmpleado','=','empleados.id')
                                    ->select('accesos.id','accesos.Usuario','empleados.Nombre as Empleado','empleados.id as idEmpleado','accesos.idEmpleado','accesos.password','accesos.Rol','accesos.Estado')
                                    ->where('accesos.'.$criterio,'like','%'.$buscar.'%')
                                    ->orderBy('accesos.id','desc')
                                    ->paginate(7);
        }

        return[
            'pagination' => [
                'total'         => $accesos->total(),
                'current_page'  => $accesos->currentPage(),
                'per_page'      => $accesos->perPage(),
                'last_page'     => $accesos->lastPage(),
                'from'          => $accesos->firstItem(),
                'to'            => $accesos->lastItem(),
            ],
            'accesos'  =>  $accesos
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
        $acceso = new Acceso();
        $acceso->Usuario = $request->Usuario;
        $acceso->idEmpleado = $request->idEmpleado;
        $acceso->password = bcrypt($request->password);
        $acceso->Rol = $request->Rol;
        $acceso->Estado = 'Activo';
        $acceso->save();
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
        $acceso = Acceso::findOrFail($request->id);
        $acceso->Usuario = $request->Usuario;
        $acceso->idEmpleado = $request->idEmpleado;
        $acceso->password = bcrypt($request->password);
        $acceso->Rol = $request->Rol;
        $acceso->Estado = 'Activo';
        $acceso->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $acceso = Acceso::findOrFail($request->id);
        $acceso->Estado = 'Inactivo';
        $acceso->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $acceso = Acceso::findOrFail($request->id);
        $acceso->Estado = 'Activo';
        $acceso->save();
    }
}
