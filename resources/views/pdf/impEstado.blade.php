<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estado</title>
    <style>
        *{
            margin: 3px;
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
            /*margin-top: 25px;*/
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
        }
        th,td{
            text-align: left;
           /* border: 1px solid;*/
            border-spacing: 0;
            border-collapse: collapse;
        }
        
        th{
            border-top: 1px solid;
            border-bottom: 1px solid;
            text-align: center;
        }
        tfoot tr td{
            padding-top: 10px;
        }
        .center{
            text-align: center
        }
    </style>
</head>
<body>
    <!--- ORIGINAL -->
    <header>
        <div class="titulo">
            <h3 class="bold text-center">Funeraria Carrasco Chavarria</h3>
            <h4 class="text-center" style="font-family: Arial; font-weight: normal">Dirección: Del porton de parqueo de la UPOLI, 25vrs. al norte</h4>
            <h4 class="text-center" style="font-family: Arial; font-weight: normal">Telf.:22258-0022 Cel.:7721-6123</h4>
            <hr>
        </div>
        <div class="datos" style="margin-top: 15px">
            <h3>ESTADO DE CUENTA</h3>
            <p style="text-align: left"><b>Fecha Impresión:</b>{{$hoy}}</p>
            @foreach ($cliente as $c)
                <p style="text-align: left"><b>Cliente:</b>{{$c->Cliente}}</p>
                <p style="text-align: left"><b>Dirección:</b>{{$c->Direccion}}</p>
            @endforeach
        </div>
    </header>
    <main>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Deuda C$</th>
                    <th>Abono C$</th>
                    <th>Total C$</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $d)
                <tr>
                    <td style="border-bottom: 1px solid;" class="text-center">{{$d->Fecha}}</td>
                    <td style="border-bottom: 1px solid;" >{{$d->Descripcion}}</td>
                    <td style="border-bottom: 1px solid;" class="text-center">{{$d->Deuda}}</td>
                    <td style="border-bottom: 1px solid;" class="text-center">{{$d->Abono}}</td>
                    <td style="border-bottom: 1px solid;" class="text-center">{{$d->TotalRestante}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>