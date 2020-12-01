<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Cobro</title>
    <style>
        *{
            margin: 0;
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
            <h2 class="text-center" style="font-family: Arial; font-weight: normal">Calendario de Cobro</h2>
            <h3 class="bold text-center">Funeraria Carrasco Chavarria</h3>
            <h3 class="bold text-center">{{$hoy}}</h3>
            <hr>
        </div>
    </header>
    <main>
        <table class="tabla">
            <thead>
                <tr>
                    <th style="width: 25%">Cliente</th>
                    <th style="width: 15%">Barrio</th>
                    <th style="width:30%">Dirección</th>
                    <th>Abono</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $d)
                <tr>
                    <td>{{$d->Cliente}}</td>
                    <td>{{$d->Barrio}}</td>
                    <td>{{$d->Direccion}}</td>
                    <td class="center">{{$d->Total}}</td>
                    <td class="center">{{$d->Total}}</td>
                    <td class="center">___________________</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>