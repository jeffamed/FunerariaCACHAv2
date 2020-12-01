<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Acceso;
use App\RoleUser;
use Illuminate\Support\Facades\DB;

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
            $accesos = Acceso::join('empleados','users.idEmpleado','=','empleados.id')
                            ->join('role_user as ru','users.id','=','ru.user_id')
                            ->join('roles as r','ru.role_id','=','r.id')
                            ->select('users.id','users.name',DB::raw('concat(empleados.Nombre," ",empleados.Apellido) as Empleado'),'empleados.id as idEmpleado','users.idEmpleado','users.password','r.name as rol','r.id as idrol','users.state')
                            ->orderBy('users.id','desc')
                            ->paginate(7);
        }else{
            $accesos = Acceso::join('empleados','users.idEmpleado','=','empleados.id')
                            ->join('role_user as ru','users.id','=','ru.user_id')
                            ->join('roles as r','ru.role_id','=','r.id')
                            ->select('users.id','users.name',DB::raw('concat(empleados.Nombre," ",empleados.Apellido) as Empleado'),'empleados.id as idEmpleado','users.idEmpleado','users.password','r.name as rol','r.id as idrol','users.state')
                            ->where('users.'.$criterio,'like','%'.$buscar.'%')
                            ->orderBy('users.id','desc')
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
        if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();

            $acceso = new Acceso();
            $acceso->name = $request->Usuario;
            $acceso->idEmpleado = $request->idEmpleado;
            $acceso->password = bcrypt($request->password);
            $acceso->state = 'Activo';
            $acceso->save();

            $role = new RoleUser();
            $role->role_id = $request->Rol;
            $role->user_id = $acceso->id;
            $role->save();

            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }
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
        $acceso->name = $request->Usuario;
        $acceso->idEmpleado = $request->idEmpleado;
        $acceso->password = bcrypt($request->password);
        $acceso->state = 'Activo';
        $acceso->save();

        $rol = RoleUser::where('user_id','=',$request->id)->first();
        $rol->role_id = $request->Rol;
        $rol->user_id = $request->id;
        $rol->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $acceso = Acceso::findOrFail($request->id);
        $acceso->state = 'Inactivo';
        $acceso->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $acceso = Acceso::findOrFail($request->id);
        $acceso->state = 'Activo';
        $acceso->save();
    }
}
