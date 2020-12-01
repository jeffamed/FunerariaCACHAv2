<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibos</title>
    <style>
        *{
            margin: 3px;
            padding: 0;
        }
        body{
            margin: 0;
            margin-left: 10px;
            font-size: 15px;
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
    <header style="margin-top: 25px;">
        <div class="titulo" style="margin-bottom: 25px;">
            <h3 class="bold text-center">Funeraria Carrasco Chavarria</h3>
            <h4 class="text-center" style="font-family: Arial; font-weight: normal">Dirección: Del porton de parqueo de la UPOLI, 25vrs. al norte</h4>
            <h4 class="text-center" style="font-family: Arial; font-weight: normal">Telf.:22258-0022 Cel.:7721-6123</h4>
            <hr>
        </div>
        <table>
            @foreach ($datos as $d)
            <tr>
                <td style="width: 600px;"><h1><b>RECIBO No.{{$d->id}}</b></h1></td>
                <td><span>C$</span></td>
                <td><h3 style="border: 1px solid; padding: 5px 20px"> {{$d->Monto}}</h3></td>
            </tr>
        </table>
    </header>

    <main style="border-bottom: 1px dashed; padding-bottom: 40px; margin-top: 20px">
        <table style="font-size: 16px">
            <tbody>
                <tr>
                    <td>Recibí de </td>
                    <td style="border-bottom: 1px solid; width: 600px; text-align: center;">{{$d->Cliente}}</td>
                </tr>
                <tr>
                    <td>la cantidad de</td>
                    <td style="border-bottom: 1px solid; width: 600px; text-align: center;">C$ {{$d->Monto}}</td>
                </tr>
                <tr>
                    <td>por concepto de</td>
                    <td style="border-bottom: 1px solid; width: 600px; text-align: center;">pagó del {{$d->TipoDocumento}} </td>
                </tr>
                <tr>
                    <td>en la ciudad de </td>
                    <td style="border-bottom: 1px solid; width: 600px; text-align: center;">{{$d->fecha}}</td>
                </tr>
            </tbody>
        </table>
        <table style="margin-top: 45px;">
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-center" style="width: 200px;"><b>Saldo Pendiente:</b></td>
                </tr>
                <tr>
                    <td style="width: 250px; border-top: 1px solid; text-align: center;padding-right: 10px;"><b>Recibí Conforme</b></td>
                    <td style="width: 250px; border-top: 1px solid; text-align: center;margin-right: 10px"><b>Entregué Conforme</b></td>
                    <td style="width: 100px;" class="center"><h3 style="border: 1px solid">C$ {{$d->TotalRestante}}</h3></td>
                </tr>
            </tfoot>
        </table>
        @endforeach   
    </main>

    <!--- COPIA -->
    <header style="margin-top: 25px;">
        <div class="titulo" style="margin-bottom: 25px;">
            <h3 class="bold text-center">Funeraria Carrasco Chavarria</h3>
            <h4 class="text-center" style="font-family: Arial; font-weight: normal">Dirección: Del porton de parqueo de la UPOLI, 25vrs. al norte</h4>
            <h4 class="text-center" style="font-family: Arial; font-weight: normal">Telf.:22258-0022 Cel.:7721-6123</h4>
            <hr>
        </div>
        <table>
        @foreach ($datos as $d)
            <tr>
                <td style="width: 600px;"><h1><b>RECIBO No.{{$d->id}}</b></h1></td>
                <td><span>C$</span></td>
                <td><h3 style="border: 1px solid; padding: 5px 20px"> {{$d->Monto}}</h3></td>
            </tr>
        </table>
    </header>

    <main style="border-bottom: 1px dashed; padding-bottom: 40px; margin-top: 20px">
        <table style="font-size: 16px">
            <tbody>
                <tr>
                    <td>Recibí de </td>
                    <td style="border-bottom: 1px solid; width: 600px; text-align: center;">{{$d->Cliente}}</td>
                </tr>
                <tr>
                    <td>la cantidad de</td>
                    <td style="border-bottom: 1px solid; width: 600px; text-align: center;">C$ {{$d->Monto}}</td>
                </tr>
                <tr>
                    <td>por concepto de</td>
                    <td style="border-bottom: 1px solid; width: 600px; text-align: center;">pagó del {{$d->TipoDocumento}} </td>
                </tr>
                <tr>
                    <td>en la ciudad de </td>
                    <td style="border-bottom: 1px solid; width: 600px; text-align: center;">{{$d->fecha}}</td>
                </tr>
            </tbody>
            
        </table>
        <table style="margin-top: 45px;">
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-center" style="width: 200px;"><b>Saldo Pendiente:</b></td>
                </tr>
                <tr>
                    <td style="width: 250px; border-top: 1px solid; text-align: center;padding-right: 10px;"><b>Recibí Conforme</b></td>
                    <td style="width: 250px; border-top: 1px solid; text-align: center;margin-right: 10px"><b>Entregué Conforme</b></td>
                    <td style="width: 100px;" class="center"><h3 style="border: 1px solid">C$ {{$d->TotalRestante}}</h3></td>
                </tr>
            </tfoot>
        </table>
        @endforeach
    </main>
</body>
</html>