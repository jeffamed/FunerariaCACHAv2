<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ventas;
use App\DetalleVentas;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
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

        if ($buscar == '') {
            $ventas = DB::table('ventas as v')->join('clientes as c','v.idCliente','=','c.id')
            ->select('v.id','v.total',DB::RAW("Format(v.total,2) as TotalMoney"),'v.created_at','v.estado',DB::RAW('concat(c.Nombre," ",c.Apellido) as cliente'))
            ->orderBy('id','desc')
            ->paginate(9);
        }else{
            $ventas = DB::table('ventas as v')->join('clientes as c','v.idCliente','=','c.id')
            ->select('v.id','v.total',DB::RAW("Format(v.total,2) as TotalMoney"),'v.created_at','v.estado',DB::RAW('concat(c.Nombre," ",c.Apellido) as cliente'))
            ->where($criterio,'like','%'.$buscar.'%')
            ->orderBy('id','desc')
            ->paginate(9);
        }
        return[
            'pagination' => [
                'total'         => $ventas->total(),
                'current_page'  => $ventas->currentPage(),
                'per_page'      => $ventas->perPage(),
                'last_page'     => $ventas->lastPage(),
                'from'          => $ventas->firstItem(),
                'to'            => $ventas->lastItem(),
            ],
            'ventas' => $ventas
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
         
        if (!$request->ajax())  return redirect('/');
        try {

            DB::beginTransaction();
            $ventas = new Ventas();
            $ventas->cambioDolar = $request->Dolar;
            $ventas->idCliente = $request->idCliente;
            $ventas->total = $request->Total;
            $ventas->totalDolar = $request->Total / $request->Dolar;
            $ventas->estado = 'Facturado';
            
            $ventas->save();

            $detalles = $request->data;
            
            foreach ($detalles as $ep => $det) {
                $detalle = new DetalleVentas();
                $detalle->idVenta = $ventas->id;
                $detalle->idServicio  = $det['idservicio'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->save();
            }
                        
            DB::commit();

            return ['id' => $ventas->id];
            
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function informacion(Request $request)
    {
        $buscar = $request->id;
        $ventas = DB::table('ventas as v')
            ->join('clientes as c','v.idCliente','=','c.id')
            ->join('detalle_venta as dv', 'v.id','=','dv.idVenta')
            ->join('servicios as s','dv.idServicio','=','s.id')
            ->select('v.id',DB::raw('Format(v.total,2) as total'),'v.created_at','v.estado',DB::RAW('concat(c.Nombre," ",c.Apellido) as cliente'),
             's.Nombre','dv.cantidad',DB::RAW('FORMAT(dv.precio,2) as precios, Format((dv.precio*dv.cantidad),2) as Subtotal'), 'dv.precio')
            ->where('v.id','=',$buscar)
            ->orderBy('id','desc')
            ->get();

        return ['ventas'=>$ventas];
    }

    public function ImprimirVenta(Request $request)
    {
        $id = $request->id;
        
        $infobasic = DB::select('call sp_PrintVentas(?)', [$id]);

        $detalle = DB::select('call sp_DetalleVentas(?)', [$id]);

        $pdf = \PDF::loadView('pdf.impFactura', ['venta'=>$infobasic,'detalle'=>$detalle])->setPaper("letter","landscape");
        return $pdf->stream();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $factura = Ventas::findOrFail($request->id);
        $factura->motivoAnulacion = $request->Motivo;
        $factura->estado = 'Anular';
        $factura->save();
    }
    
}
