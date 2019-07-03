<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;

class EmpleadosController extends Controller
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
            $empleados = Empleado::orderBy('id','desc')->paginate(5);
        }else{
            $empleados = Empleado::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(5);
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

    public function seleccionar()
    {
        $empleados = Empleado::where('Estado','=','Activo')->select('id','Nombre')
                        ->orderBy('nombre','desc')->get();
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
         // if (!$request->ajax()) return redirect('/');
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
         // if (!$request->ajax()) return redirect('/');
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
        // if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id);
        $empleado->Estado = 'Inactivo';
        $empleado->save();
    }

    public function activar(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');
        $empleado = Empleado::findOrFail($request->id);
        $empleado->Estado = 'Activo';
        $empleado->save();
    }
}
