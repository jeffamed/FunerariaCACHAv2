<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use Illuminate\Support\Facades\DB;

class EmpleadosController extends Controller
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
            $empleados = Empleado::orderBy('id','desc')->paginate(7);
        }else{
            $empleados = Empleado::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(7);
        }

        return[
            'pagination' => [
                'total'         => $empleados->total(),
                'current_page'  => $empleados->currentPage(),
                'per_page'      => $empleados->perPage(),
                'last_page'     => $empleados->lastPage(),
                'from'          => $empleados->firstItem(),
                'to'            => $empleados->lastItem(),
            ],
            'empleados'  =>  $empleados
        ];
    }

    public function seleccionar(Request $request)
    {
         if (!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $empleados = Empleado::where('Estado','=','Activo')
                            -> select('id',DB::raw('concat(Nombre," ",Apellido) as Nombre'))
                            -> orderBy('nombre','desc')
                            -> get();
        // where('Nombre','like','%'.$filtro.'%')
        return ['empleados'=>$empleados];
    }

    public function listaColector(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleados = DB::table('empleados as e')->join('users as u','e.id','=','u.idEmpleado')
                    ->join('role_user as ru','u.id','=','ru.user_id')
                    ->join('roles as r','ru.role_id', '=', 'r.id')
                    ->select('e.id',DB::raw('concat(e.Nombre," ",e.Apellido) as Nombre'))
                    ->where([['r.slug', '=', 'Colector'],['e.Estado', '=', 'Activo']])
                    -> orderBy('e.Nombre','asc')
                    -> get();
        return ['empleados'=>$empleados];        
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
         $empleado = new Empleado();
         $empleado->Nombre = $request->Nombre;
         $empleado->Apellido = $request->Apellido;
         $empleado->Direccion = $request->Direccion;
         $empleado->Telefono = $request->Telefono;
         $empleado->Cedula = $request->Cedula;
         $empleado->Estado = 'Activo';
         $empleado->save();
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
        $empleado = Empleado::findOrFail($request->id);
        $empleado->Nombre = $request->Nombre;
        $empleado->Apellido = $request->Apellido;
        $empleado->Direccion = $request->Direccion;
        $empleado->Telefono = $request->Telefono;
        $empleado->Cedula = $request->Cedula;
        $empleado->Estado = 'Activo';
        $empleado->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id);
        $empleado->Estado = 'Inactivo';
        $empleado->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id);
        $empleado->Estado = 'Activo';
        $empleado->save();
    }
}
