<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\Contrato;
use App\Financiamiento;
use App\CuentasxCobrar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FacturasController extends Controller
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
            $facturas = Factura::orderBy('id','desc')->paginate(9);
        }else{
            $facturas = Factura::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(9);
        }

        return[
            'pagination' => [
                'total'         => $facturas->total(),
                'current_page'  => $facturas->currentPage(),
                'per_page'      => $facturas->perPage(),
                'last_page'     => $facturas->lastPage(),
                'from'          => $facturas->firstItem(),
                'to'            => $facturas->lastItem(),
            ],
            'facturas'  =>  $facturas
        ];
    }

    public function InfoDocumento(Request $request){
        $tipoDoc = $request->tipoDocumento;
        $buscarDoc = $request->numeroDoc;
        if ($tipoDoc == 'Contrato') {
            $informacion = CuentasxCobrar::join('contratos as c','cuentas_x_cobrar.idDocumento','=','c.id')->join('clientes as cl','c.idCliente','=','cl.id')
                            ->select('cuentas_x_cobrar.idCxC','cl.id as idCliente',DB::raw('concat(cl.Nombre," ",cl.Apellido) as Cliente'),'c.Cuota','cuentas_x_cobrar.Total as subTotal','c.Total')
                            ->where([['c.Contrato','=',$buscarDoc], ['cuentas_x_cobrar.Estado','=','Por Cobrar'],['c.Estado','=','Activo'],['cuentas_x_cobrar.Tipo_Doc','=','Contrato']])
                            ->first();
        } else{
            $informacion = CuentasxCobrar::join('financiamientos as f','cuentas_x_cobrar.idDocumento','=','f.id')
                                        -> join ('contratos as c','f.idContrato','=','c.id')
                                        -> join('clientes as cl','c.idCliente','=','cl.id')
                                        -> select('cuentas_x_cobrar.idCxC','cl.id as idCliente',DB::raw('concat(cl.Nombre," ",cl.Apellido) as Cliente'),'f.Cuota','cuentas_x_cobrar.Total as subTotal','cuentas_x_cobrar.Total')
                                        -> where([['f.id','=',$buscarDoc], ['cuentas_x_cobrar.Estado','=','Por Cobrar'] ,['f.Estado','=','Activo'],['cuentas_x_cobrar.Tipo_Doc','=','Financiamiento']])
                                        -> first();
        }
                
        return ["informacion"=>$informacion];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $factura = new Factura();
        $fechaAct = new Carbon();
        $factura->idDolar =  $request->idDolar;
        $factura->idCxC = $request->idDocumento;
        $factura->TipoDocumento = $request->TipoDocumento.' #'.$request->NumContrato;
        $factura->Monto = $request->Monto;
        $factura->MontoDolar = $request->Monto / $request->Dolar;
        $factura->Fecha_Pago = Carbon::now();
        $factura->Documento = $request->TipoDocumento;
        $factura->TotalRestante = $request->Saldo - $request->Monto;
        $factura->Estado = 'Activo';
        $factura->idcliente = $request->idCliente;
        $factura->usuario = \Auth::user()->idEmpleado;
        $factura->save();        
        
    }

    public function anular(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $factura = Factura::findOrFail($request->id);
        $factura->Anulacion = $request->Motivo;
        $factura->Estado = 'Anulado';
        $factura->save();
    }

    public function imprimirFactura($id, $doc)
    {
        $datos = DB::select('call sp_datosRecibos(?, ?)', [$id, $doc]);

        $usuario = \Auth::user()->name;

        $pdf = \PDF::loadView('pdf.recibos', ['datos'=>$datos, 'user'=>$usuario])->setPaper("letter","portrait");
        return $pdf->stream();
    }

    public function informacion(Request $request)
    {
        $id = $request->idFactura;
        $documento = $request->Doc;
        if ($documento == 'Contrato') {
            $info = DB::select('call sp_CargarReciboContrato(?)',[$id]);
        } else {
            $info = DB::select('call sp_CargarReciboFinanciamiento(?)',[$id]);
        }
        return ['informacion'=>$info];
    }
}
