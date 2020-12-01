<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado Recibo</title>
    <style>
        *{
            margin: 2px;
            padding: 0;
        }
        body{
            margin: 0;
            margin-left: 10px;
            font-size: 13px;
            font-family: Arial,Verdana, Geneva, Tahoma, sans-serif;
        }
        .d-flex{
            display: flex;
        }
        .bold{
            font-weight: bold
        }
        .text-center{
            text-align: center
        }
        .f-left{
            float: left;
        }
        .w-33{
            width: 32%;
        }
        .border{
            border: 1px solid;
        }
        .datos{
            width: 100%;
            height: 10%;
            text-align: center;
        }
        .item-datos{
            width: 30%;
            display: inline-block;
        }
        .datos2{
            width: 100%;
            height: 3%;
            text-align: left;
        }
        .b-bottom{
            padding-bottom: -10px;
            margin-bottom: 10px;
            border-bottom: 2px solid;
        }
        main{
            width: 100%;
        }
        .tabla{
            width: 100%;
            border-spacing: 0;
            padding: 0;
            margin: 0;
            margin-top: 15px;
        }
        th,td{
            text-align: left;
           /* border: 1px solid;*/
            padding-top: 5px;
            margin-top: 5px;
            border-spacing: 0;
            border-collapse: collapse;
        }
        
        th{
            border-top: 1px solid;
            border-bottom: 1px solid;
            text-align: center;
        }
        .center{
            text-align: center
        }
    </style>
</head>
<body>
    <header>
        <div class="titulo">
            <h2 class="text-center" style="font-family: Arial; font-weight: normal">Listado de Recibos</h2>
            <h3 class="bold text-center">Funeraria Carrasco Chavarria</h3>
            <hr>
        </div>
    </header>
    <main>
        @foreach($total as $t)
        <div>
            <p class="f-left"><b>Recibos del {{$del}} al {{$al}}</b></p>
            <p style="text-align: right;"><b>Fecha Impresión:</b>{{$hoy}}</p>
        </div>
        @endforeach
        <table class="tabla">
            <thead>
                <tr>
                    <th style="width: 15%">Fecha</th>
                    <th>Num Recibo</th>
                    <th style="width: 30%">Cliente</th>
                    <th style="width:20%">Tipo Doc</th>
                    <th>Abono C$</th>
                    <th>Abono $</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $d)
                    <tr>
                        <td class="center">{{$d->FechaPago}}</td>
                        <td class="center">{{$d->id}}</td>
                        <td>{{$d->Cliente}}</td>
                        <td class="center">{{$d->TipoDocumento}}</td>
                        <td class="center">{{$d->Monto}}</td>
                        <td class="center">{{$d->MontoDolar}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                @foreach($total as $t)
                    <tr>
                        <td style="font-weight: bold" colspan="3">Total Recibos: {{$t->TotalRec}}</td>
                        <td style="font-weight: bold">Total</td>
                        <td style="font-weight: bold; text-align: center">C$ {{$t->TotalCord}}</td>
                        <td style="font-weight: bold; text-align: center">$ {{$t->TotalDol}}</td>
                    </tr>
                @endforeach
            </tfoot>
        </table>
    </main>
</body>
</html>