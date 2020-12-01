<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;
use App\Permisos;
use App\Permiso_Rol;
use DB;

class RolesController extends Controller
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
            $roles = Roles::orderBy('id','desc')->paginate(9);
        }else{
            $roles = Roles::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(7);
        }

        return[
            'pagination' => [
                'total'         => $roles->total(),
                'current_page'  => $roles->currentPage(),
                'per_page'      => $roles->perPage(),
                'last_page'     => $roles->lastPage(),
                'from'          => $roles->firstItem(),
                'to'            => $roles->lastItem(),
            ],
            'roles'  =>  $roles
        ];
    }

    public function listar(Request $request)
    {
        $roles = Roles::orderBy('id','asc')->get(); 
        return ['roles'=>$roles];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if (!$request->ajax())  return redirect('/');
        try {
            DB::beginTransaction();
            $roles = new Roles();
            $roles->name = $request->Nombre;
            $roles->slug = $request->Nombre;
            $roles->description = $request->Descripcion;
            $roles->save();

            $data = $request->data;

            foreach ($data as $det) {
                $permisos = new Permiso_Rol();
                $permisos->role_id = $roles->id;
                $permisos->permission_id = $det['idpermiso'];
                $permisos->save();
            }

            DB::commit();
            
        } catch (\Throwable $th) {
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
        if (!$request->ajax())  return redirect('/');
        $roles = Roles::findOrFail($request->id);
        $roles->name = $request->Nombre;
        $roles->description = $request->Descripcion;
        $roles->save();
    }

    public function listarpermisos(Request $request)
    {
        $slug = $request->Buscar;
        $permisos = Permisos::where('slug','LIKE',$slug.'%')->get();
        return ['permisos'=>$permisos];
    }

    public function permisosDisponibles(Request $request)
    {
        $slug = $request->slug;
        $idrol = $request->idrol;

        $permisos = DB::table('permissions as p')
        ->whereNotIn('p.id', DB::table('permission_role as pr')->where('pr.role_id','=',$idrol)->pluck('pr.permission_id'))
        ->where('p.slug','LIKE',$slug.'%')->get();
        //$permisos = DB::select('call sp_asignPermiRoles(?, ?)',[$idrol,$slug]);
        return ['permisos'=>$permisos];
    }

    public function permisosAsignado(Request $request)
    {
        $id = $request->id;
        $permisos = DB::table('permission_role as pr')->join('permissions as p', 'pr.permission_id','=','p.id')
        ->select('p.id','p.name','pr.id as idpermisorol','p.description')->where('pr.role_id','=',$id)->get();
        return ['permisos'=>$permisos];

    }

    public function permisosRegistrar(Request $request)
    {
        $permisos = new Permiso_Rol();
        $permisos->role_id = $request->rol;
        $permisos->permission_id = $request->idpermiso;
        $permisos->save();

    }

    public function permisosEliminar(Request $request, $id)
    {
        $permisos = Permiso_Rol::findOrFail($id);
        $permisos->delete();

    }
}
