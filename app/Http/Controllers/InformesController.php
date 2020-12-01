<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TasaCambio;
use DB;
use Carbon\Carbon;

class InformesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CobroDia(Request $request)
    {   //dd(Carbon::now()->startOfWeek()->addDay(4)->format('Y-m-d H:i')); obtener las fechas de los viernes


        
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $id= \Auth::user()->id;
        $tipo = DB::table('role_user')->select('role_id')->where('user_id','=',$id)->pluck('role_id')->first();
        $hoy = Carbon::now();
        $fecha = $hoy->format('Y-m-d');
        
        if($tipo == 2){
            if($buscar == ''){
                //$cobros = DB::select('call sp_cobroDiaColector(?)', [\Auth::user()->idEmpleado]);
                $p1 = DB::table('cuentas_x_cobrar as cc')->join('financiamientos as f','cc.idDocumento','=','f.id')->join('contratos as c','f.idContrato','=','c.id')
                ->join('clientes as cl','c.idCliente','=','cl.id')->join('barrios as b','cl.idBarrio','=','b.id')->join('servicios as s','c.idServicio','=','s.id')
                ->join('zonas as z','b.idZona','=','z.id')
                ->select(DB::RAW("cc.idCxC,cl.id as idCliente ,cc.Fecha_Cobro, cc.Estado, format(cc.Total, 2) as Total, cc.Total as Total2, CONCAT(cl.Nombre,' ',cl.Apellido) as Cliente,
                b.id,b.Nombre as Barrio,cl.Direccion, format((f.Total/f.Cuota),2) as Abono, cc.Tipo_Doc, s.Nombre as servicio, f.id as numerodoc, c.id as idcontrato"))
                ->where([['cc.Fecha_Cobro','=',$fecha],['cc.Estado','=','Por Cobrar'],['cc.Tipo_Doc','=','Financiamiento'],['z.idColector','=',\Auth::user()->idEmpleado]]);
                $cobros = DB::table('cuentas_x_cobrar as cc')->join('contratos as c','cc.idDocumento','=','c.id')
                ->join('clientes as cl','c.idCliente','=','cl.id')->join('barrios as b','cl.idBarrio','=','b.id')->join('servicios as s','c.idServicio','=','s.id')
                ->join('zonas as z','b.idZona','=','z.id')
                ->select(DB::RAW("cc.idCxC,cl.id as idCliente ,cc.Fecha_Cobro, cc.Estado, format(cc.Total,2) as Total,cc.Total as Total2, CONCAT(cl.Nombre,' ',cl.Apellido) as Cliente,
                b.id,b.Nombre as Barrio, cl.Direccion, format((c.Total/c.Cuota),2) as Abono, cc.Tipo_Doc, s.Nombre as servicio, c.Contrato as numerodoc, c.id as idcontrato"))
                ->where([['cc.Fecha_Cobro','=',$fecha],['cc.Estado','=','Por Cobrar'],['cc.Tipo_Doc','=','Contrato'],['z.idColector','=',\Auth::user()->idEmpleado]])
                ->union($p1)
                ->paginate(10);
            }else{
                $p1 = DB::table('cuentas_x_cobrar as cc')->join('financiamientos as f','cc.idDocumento','=','f.id')->join('contratos as c','f.idContrato','=','c.id')
                ->join('clientes as cl','c.idCliente','=','cl.id')->join('barrios as b','cl.idBarrio','=','b.id')->join('servicios as s','c.idServicio','=','s.id')
                ->join('zonas as z','b.idZona','=','z.id')
                ->select(DB::RAW("cc.idCxC,cl.id as idCliente ,cc.Fecha_Cobro, cc.Estado, format(cc.Total, 2) as Total, cc.Total as Total2, CONCAT(cl.Nombre,' ',cl.Apellido) as Cliente,
                b.id,b.Nombre as Barrio,cl.Direccion, format((f.Total/f.Cuota),2) as Abono, cc.Tipo_Doc, s.Nombre as servicio, f.id as numerodoc, c.id as idcontrato"))
                ->where([['cc.Fecha_Cobro','=',$fecha],['cc.Estado','=','Por Cobrar'],['cc.Tipo_Doc','=','Financiamiento'],['z.idColector','=',\Auth::user()->idEmpleado],[$criterio,'like','%'.$buscar.'%']]);
                $cobros = DB::table('cuentas_x_cobrar as cc')->join('contratos as c','cc.idDocumento','=','c.id')
                ->join('clientes as cl','c.idCliente','=','cl.id')->join('barrios as b','cl.idBarrio','=','b.id')->join('servicios as s','c.idServicio','=','s.id')
                ->join('zonas as z','b.idZona','=','z.id')
                ->select(DB::RAW("cc.idCxC,cl.id as idCliente ,cc.Fecha_Cobro, cc.Estado, format(cc.Total,2) as Total,cc.Total as Total2, CONCAT(cl.Nombre,' ',cl.Apellido) as Cliente,
                b.id,b.Nombre as Barrio, cl.Direccion, format((c.Total/c.Cuota),2) as Abono, cc.Tipo_Doc, s.Nombre as servicio, c.Contrato as numerodoc, c.id as idcontrato"))
                ->where([['cc.Fecha_Cobro','=',$fecha],['cc.Estado','=','Por Cobrar'],['cc.Tipo_Doc','=','Contrato'],['z.idColector','=',\Auth::user()->idEmpleado],[$criterio,'like','%'.$buscar.'%']])
                ->union($p1)
                ->paginate(10);
            }
            return [
                'pagination' => [
                'total'         => $cobros->total(),
                'current_page'  => $cobros->currentPage(),
                'per_page'      => $cobros->perPage(),
                'last_page'     => $cobros->lastPage(),
                'from'          => $cobros->firstItem(),
                'to'            => $cobros->lastItem(),
            ],'cobros'=> $cobros];
        }else{
            //$cobros = DB::select('call sp_cobroDia');
            if($buscar == ''){
                $p1 = DB::table('cuentas_x_cobrar as cc')->join('financiamientos as f','cc.idDocumento','=','f.id')->join('contratos as c','f.idContrato','=','c.id')
                ->join('clientes as cl','c.idCliente','=','cl.id')->join('barrios as b','cl.idBarrio','=','b.id')->join('servicios as s','c.idServicio','=','s.id')
                ->select(DB::RAW("cc.idCxC,cl.id as idCliente ,cc.Fecha_Cobro, cc.Estado, format(cc.Total, 2) as Total, cc.Total as Total2, CONCAT(cl.Nombre,' ',cl.Apellido) as Cliente,
                b.id,b.Nombre as Barrio,cl.Direccion, format((f.Total/f.Cuota),2) as Abono, cc.Tipo_Doc, s.Nombre as servicio, f.id as numerodoc, c.id as idcontrato"))
                ->where([['cc.Fecha_Cobro','=',$fecha],['cc.Estado','=','Por Cobrar'],['cc.Tipo_Doc','=','Financiamiento']]);
                $cobros = DB::table('cuentas_x_cobrar as cc')->join('contratos as c','cc.idDocumento','=','c.id')
                ->join('clientes as cl','c.idCliente','=','cl.id')->join('barrios as b','cl.idBarrio','=','b.id')->join('servicios as s','c.idServicio','=','s.id')
                ->select(DB::RAW("cc.idCxC,cl.id as idCliente ,cc.Fecha_Cobro, cc.Estado, format(cc.Total,2) as Total,cc.Total as Total2, CONCAT(cl.Nombre,' ',cl.Apellido) as Cliente,
                b.id,b.Nombre as Barrio, cl.Direccion, format((c.Total/c.Cuota),2) as Abono, cc.Tipo_Doc, s.Nombre as servicio, c.Contrato as numerodoc, c.id as idcontrato"))
                ->where([['cc.Fecha_Cobro','=',$fecha],['cc.Estado','=','Por Cobrar'],['cc.Tipo_Doc','=','Contrato']])
                ->union($p1)
                ->paginate(10);
            }else{
                $p1 = DB::table('cuentas_x_cobrar as cc')->join('financiamientos as f','cc.idDocumento','=','f.id')->join('contratos as c','f.idContrato','=','c.id')
                ->join('clientes as cl','c.idCliente','=','cl.id')->join('barrios as b','cl.idBarrio','=','b.id')->join('servicios as s','c.idServicio','=','s.id')
                ->select(DB::RAW("cc.idCxC,cl.id as idCliente ,cc.Fecha_Cobro, cc.Estado, format(cc.Total, 2) as Total, cc.Total as Total2, CONCAT(cl.Nombre,' ',cl.Apellido) as Cliente,
                b.id,b.Nombre as Barrio,cl.Direccion, format((f.Total/f.Cuota),2) as Abono, cc.Tipo_Doc, s.Nombre as servicio, f.id as numerodoc, c.id as idcontrato"))
                ->where([['cc.Fecha_Cobro','=',$fecha],['cc.Estado','=','Por Cobrar'],['cc.Tipo_Doc','=','Financiamiento'],[$criterio,'like','%'.$buscar.'%']]);
                $cobros = DB::table('cuentas_x_cobrar as cc')->join('contratos as c','cc.idDocumento','=','c.id')
                ->join('clientes as cl','c.idCliente','=','cl.id')->join('barrios as b','cl.idBarrio','=','b.id')->join('servicios as s','c.idServicio','=','s.id')
                ->select(DB::RAW("cc.idCxC,cl.id as idCliente ,cc.Fecha_Cobro, cc.Estado, format(cc.Total,2) as Total,cc.Total as Total2, CONCAT(cl.Nombre,' ',cl.Apellido) as Cliente,
                b.id,b.Nombre as Barrio, cl.Direccion, format((c.Total/c.Cuota),2) as Abono, cc.Tipo_Doc, s.Nombre as servicio, c.Contrato as numerodoc, c.id as idcontrato"))
                ->where([['cc.Fecha_Cobro','=',$fecha],['cc.Estado','=','Por Cobrar'],['cc.Tipo_Doc','=','Contrato'],[$criterio,'like','%'.$buscar.'%']])
                ->union($p1)
                ->paginate(10);
            }
            return [
                'pagination' => [
                'total'         => $cobros->total(),
                'current_page'  => $cobros->currentPage(),
                'per_page'      => $cobros->perPage(),
                'last_page'     => $cobros->lastPage(),
                'from'          => $cobros->firstItem(),
                'to'            => $cobros->lastItem(),
            ],'cobros'=> $cobros];
        }
    }

    public function tcantcobro(Request $request)
    {
        $id= \Auth::user()->id;
        $tipo = DB::table('role_user')->select('role_id')->where('user_id','=',$id)->pluck('role_id')->first();
        if($tipo != 2){
            $cantidad = DB::select('call sp_CantCobrado');
            return ['cantidad'=> $cantidad];
        }else{
            $cantidad = DB::select('call sp_CantCobradoColector(?)',[\Auth::user()->idEmpleado]);
            return ['cantidad'=> $cantidad];
        }

    }

    public function MontoCobrado(Request $request)
    {
        $id= \Auth::user()->id;
        $tipo = DB::table('role_user')->select('role_id')->where('user_id','=',$id)->pluck('role_id')->first();
        if($tipo != 2){
            $monto = DB::select('call sp_MontoCobrado');
            return ['monto'=> $monto];
        }else{
            $monto = DB::select('call sp_MontoCobradoColector(?)',[\Auth::user()->idEmpleado]);
            return ['monto'=> $monto];
        }
    }

    public function CobroFaltante(Request $request)
    {
        $id= \Auth::user()->id;
        $tipo = DB::table('role_user')->select('role_id')->where('user_id','=',$id)->pluck('role_id')->first();
        if($tipo != 2){
            $faltante = DB::select('call sp_CobrosFaltante');
            return ['faltante'=> $faltante];
        }else{
            $faltante = DB::select('call sp_CobrosFaltanteColector(?)',[\Auth::user()->idEmpleado]);
            return ['faltante'=> $faltante];
        }
    }
    public function DiaActual()
    {
        $hoy = Carbon::now();
        $fecha = $hoy->format('Y-m-d');
        return ['fecha'=>$fecha];
    }

    public function CalendarioCobro($id, $fecha1, $fecha2)
    {
        $datos = DB::select("(select concat(cl.Nombre,' ',cl.Apellido) as Cliente, b.Nombre as Barrio, cl.Direccion, format(cc.Total, 2) as Total, cc.FechaPropuestaP, z.Nombre, cc.Fecha_Cobro 
        from empleados as e inner join zonas as z on e.id = z.idColector inner join barrios as b on z.id = b.idZona inner join clientes as cl
        on b.id = cl.idBarrio inner join contratos as c on cl.id = c.idCliente inner join cuentas_x_cobrar as cc on c.id = cc.idDocumento
        where e.Estado = 'Activo' and e.id=".$id." and cc.Tipo_Doc = 'Contrato' and cc.Total > 0
        and cc.Fecha_Cobro BETWEEN '".$fecha1."' and '".$fecha2."')
        union
        (select concat(cl.Nombre,' ',cl.Apellido) as Cliente, b.Nombre as Barrio, cl.Direccion, format(cc.Total, 2) as Total, cc.FechaPropuestaP, z.Nombre, cc.Fecha_Cobro 
        from empleados as e inner join zonas as z on e.id = z.idColector inner join barrios as b on z.id = b.idZona inner join clientes as cl
        on b.id = cl.idBarrio inner join contratos as c on cl.id = c.idCliente inner join financiamientos as f on c.id = f.idContrato
        inner join cuentas_x_cobrar as cc on f.id = cc.idDocumento
        where e.Estado = 'Activo' and e.id=".$id." and cc.Tipo_Doc = 'Financimiento' and cc.Total > 0
        and cc.Fecha_Cobro BETWEEN '".$fecha1."' and '".$fecha2."');");

        $usuario = \Auth::user()->name;

        $hoy = Carbon::now()->format('d/m/Y');

        $pdf = \PDF::loadView('pdf.calendariocobro',['user'=>$usuario, 'datos'=>$datos, 'hoy'=>$hoy])->setPaper("letter","landscape");
        return $pdf->stream();
    } 
    public function ListadoRecibo($id, $fecha1, $fecha2)
    {
        $datos = DB::select("select f.id,concat(c.Nombre,' ',c.Apellido) as Cliente, f.TipoDocumento, DATE_FORMAT(f.Fecha_Pago,'%d/%m/%Y') as FechaPago, format(f.Monto, 2) as Monto , format(f.MontoDolar,2) as MontoDolar, CONCAT(e.Nombre,' ',e.Apellido) as Empleado
        from facturas as f inner join clientes as c on f.idcliente = c.id inner join empleados as e on f.usuario = e.id 
        where f.usuario = ".$id." and f.Fecha_Pago between '".$fecha1."' and '".$fecha2."'");

        $total = DB::select("select format(sum(f.Monto),2) as TotalCord, format(sum(f.MontoDolar),2) as TotalDol, count(f.id) as TotalRec, Concat(e.Nombre,' ',e.Apellido) as Colector
        from facturas as f  inner join clientes as c on f.idcliente = c.id inner join empleados as e on f.usuario = e.id 
        where f.usuario = ".$id." and f.Fecha_Pago between '".$fecha1."' and '".$fecha2."' group by e.Nombre, e.Apellido");

        $usuario = \Auth::user()->name;

        $hoy = Carbon::now()->format('d/m/Y');

        $del = $fecha1;

        $al = $fecha2;

        $pdf = \PDF::loadView('pdf.listadorecibo',['user'=>$usuario, 'datos'=>$datos, 'hoy'=>$hoy, 'total'=>$total, 'del'=>$del, 'al'=>$al])->setPaper("letter","portraint");
        return $pdf->stream();
    } 
    public function ListadoReciboTodos($fecha1, $fecha2)
    {
        $datos = DB::select("select f.id,concat(c.Nombre,' ',c.Apellido) as Cliente, f.TipoDocumento, DATE_FORMAT(f.Fecha_Pago,'%d/%m/%Y') as FechaPago, format(f.Monto, 2) as Monto , format(f.MontoDolar,2) as MontoDolar, CONCAT(e.Nombre,' ',e.Apellido) as Empleado
        from facturas as f inner join clientes as c on f.idcliente = c.id inner join empleados as e on f.usuario = e.id 
        where f.Fecha_Pago between '".$fecha1."' and '".$fecha2."'");

        $total = DB::select("select format(sum(f.Monto),2) as TotalCord, format(sum(f.MontoDolar),2) as TotalDol, count(f.id) as TotalRec, Concat(e.Nombre,' ',e.Apellido) as Colector
        from facturas as f  inner join clientes as c on f.idcliente = c.id inner join empleados as e on f.usuario = e.id 
        where f.Fecha_Pago between '".$fecha1."' and '".$fecha2."' group by e.Nombre, e.Apellido");

        $usuario = \Auth::user()->name;

        $hoy = Carbon::now()->format('d/m/Y');

        $del = $fecha1;

        $al = $fecha2;

        $pdf = \PDF::loadView('pdf.listadorecibotodos',['user'=>$usuario, 'datos'=>$datos, 'hoy'=>$hoy, 'total'=>$total, 'del'=>$del, 'al'=>$al])->setPaper("letter","portraint");
        return $pdf->stream();
    } 
    public function ListadoFactura($fecha1, $fecha2)
    {
        $datos = DB::select("select concat(cl.Nombre,' ',cl.Apellido) as Cliente, format(v.cambioDolar,2) as Cambio, format(v.total,2) as Total, format(v.totalDolar,2) as TotalDolar,v.estado, DATE_FORMAT(v.created_at,'%d/%m/%Y') as FechaRegistro
        from ventas as v inner join clientes as cl on v.idCliente = cl.id
        where v.created_at between '".$fecha1."' and '".$fecha2."'");

        $total = DB::select("select count(v.id) as TotalVenta, format(sum(v.total),2) as Total, format(sum(v.totalDolar),2) as TotalDolar
       from ventas as v inner join clientes as cl on v.idCliente = cl.id
       where v.created_at between '".$fecha1."' and '".$fecha2."' group by v.id, v.total,v.totalDolar");

        $usuario = \Auth::user()->name;

        $hoy = Carbon::now()->format('d/m/Y');

        $del = $fecha1;

        $al = $fecha2;

        $pdf = \PDF::loadView('pdf.listadofactura',['user'=>$usuario, 'datos'=>$datos, 'hoy'=>$hoy, 'total'=>$total, 'del'=>$del, 'al'=>$al])->setPaper("letter","portraint");
        return $pdf->stream();
    } 

    public function EstadoCuenta(Request $request)
    {
        $estado = DB::select('call sp_EstadoCuentas(?)', [$request->idCliente]);
        return ['estado'=> $estado];
    } 

    public function Estado($id)
    {
        $usuario = \Auth::user()->name;

        $datos = DB::select('call sp_EstadoCuentas(?)', [$id]);

        $hoy = Carbon::now()->format('d/m/Y');

        $cliente = DB::table('Clientes as c')
        ->select(DB::RAW("concat(c.Nombre,' ',c.Apellido) as Cliente"),'c.Direccion')->where('id','=',$id)->get();

        $pdf = \PDF::loadView('pdf.impEstado',['user'=>$usuario, 'datos'=>$datos, 'hoy'=>$hoy, 'cliente'=>$cliente])->setPaper("letter","portraint");
        return $pdf->stream();
    }

    public function EstadoContrato(Request $request)
    {
        $estado = DB::select('call sp_EstadoCuentaEsp(?)', [$request->idContrato]);
        return ['estado'=> $estado];
    } 
    
    public function VerificarTasaDia(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rps = DB::select('call sp_ConfirmaTasaDia');
        return ['rps'=>$rps];
    }

    public function UltimaTasa(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $tasa = DB::table('tasacambios')->select('Monto')->orderBy('created_at','desc')->first();
        return ['tasa'=>$tasa];
    }

    public function storedolar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $dolar = new TasaCambio();
        $dolar->Monto = $request->Cambio;
        $dolar->save();
    }
}
