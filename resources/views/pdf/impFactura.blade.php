<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Factura</title>
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
        .contenido{
            width: 100%;
        }
        .factura1, .factura2{
            width: 49%;
        }
        .factura2{
            display: inline-block;
            margin-left: 50%;
            margin-top: -60%;
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
        .footer1{
            position: fixed;
            bottom: -10px;
            left: 0px;
            right: 0px;
            height: 50px
        }
    </style>
</head>
<body>
    <div class="contenido">
        <div class="factura1">
            <!--- ORIGINAL -->
            <header>
                @foreach ($venta as $f)
                    <div class="titulo">
                        <h3 class="bold text-center">Funeraria Carrasco Chavarria</h3>
                        <h4 class="text-center" style="font-family: Arial; font-weight: normal">Dirección: Del porton de parqueo de la UPOLI, 25vrs. al norte</h4>
                        <h4 class="text-center" style="font-family: Arial; font-weight: normal">Telf.:22258-0022 Cel.:7721-6123</h4>
                        <hr>
                    </div>
                    <div class="datos2" style="margin-top: 15px; background: #3c2fecd7; color: white; width: 40%; height: 20px">
                        <h4 class="f-left" style="font-size: 15px">Cliente</h4>
                    </div>
                    <div class="datos">
                        <p style="text-align: left"><b># Factura:</b>{{$f->id}}</p>
                        <p style="text-align: left"><b>Sr(a):</b>{{$f->Cliente}}</p>
                        <p style="text-align: left"><b>Teléfono:</b>{{$f->Telefono}}</p>
                        <p style="text-align: left"><b>Dirección:</b>{{$f->Direccion}}</p>
                        <p style="text-align: left"><b>Fecha Registro:</b>{{$f->fecha}}</p>
                    </div>
                    @endforeach
                </header>
            <main>
                <table class="tabla">
                    <thead style="background:  #3c2fecd7; color: white">
                        <tr>
                            <th style="width: 40%">Servicio</th>
                            <th>Cantidad</th>
                            <th>Precio C$</th>
                            <th>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalle as $d)
                        <tr>
                            <td style="border-bottom: 1px solid;">{{$d->Nombre}}</td>
                            <td style="border-bottom: 1px solid;" class="text-center">{{$d->cantidad}}</td>
                            <td style="border-bottom: 1px solid;" class="text-center">{{$d->precio}}</td>
                            <td style="border-bottom: 1px solid;" class="text-center">{{$d->subTotal}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @foreach ($venta as $t)
                            <tr>
                                <td colspan="3" style="text-align: right; padding-right: 25px; font-weight: bold">Total C$:</td>
                                <td class="center" style="font-weight: bold">{{$t->total}}</td>
                            </tr>
                        @endforeach
                    </tfoot>
                </table>
            </main>
            <footer>
                <h3>ORIGINAL</h3>
                <p class="text-center">Gracias por adquirir nuestros servicios</p>
            </footer>
        </div>
        <div class="factura2">
            <!--- ORIGINAL -->
            <header>
                @foreach ($venta as $f)
                    <div class="titulo">
                        <h3 class="bold text-center">Funeraria Carrasco Chavarria</h3>
                        <h4 class="text-center" style="font-family: Arial; font-weight: normal">Dirección: Del porton de parqueo de la UPOLI, 25vrs. al norte</h4>
                        <h4 class="text-center" style="font-family: Arial; font-weight: normal">Telf.:22258-0022 Cel.:7721-6123</h4>
                        <hr>
                    </div>
                    <div class="datos2" style="margin-top: 15px; background: #3c2fecd7; color: white; width: 40%; height: 20px">
                        <h4 class="f-left" style="font-size: 15px">Cliente</h4>
                    </div>
                    <div class="datos">
                        <p style="text-align: left"><b># Factura:</b>{{$f->id}}</p>
                        <p style="text-align: left"><b>Sr(a):</b>{{$f->Cliente}}</p>
                        <p style="text-align: left"><b>Teléfono:</b>{{$f->Telefono}}</p>
                        <p style="text-align: left"><b>Dirección:</b>{{$f->Direccion}}</p>
                        <p style="text-align: left"><b>Fecha Registro:</b>{{$f->fecha}}</p>
                    </div>
                    @endforeach
                </header>
            <main>
                <table class="tabla" style="margin-top: 39px">
                    <thead style="background:  #3c2fecd7; color: white">
                        <tr>
                            <th style="width: 40%">Servicio</th>
                            <th>Cantidad</th>
                            <th>Precio C$</th>
                            <th>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalle as $d)
                        <tr>
                            <td style="border-bottom: 1px solid;">{{$d->Nombre}}</td>
                            <td style="border-bottom: 1px solid;" class="text-center">{{$d->cantidad}}</td>
                            <td style="border-bottom: 1px solid;" class="text-center">{{$d->precio}}</td>
                            <td style="border-bottom: 1px solid;" class="text-center">{{$d->subTotal}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @foreach ($venta as $t)
                            <tr>
                                <td colspan="3" style="text-align: right; padding-right: 25px; font-weight: bold">Total C$:</td>
                                <td class="center" style="font-weight: bold">{{$t->total}}</td>
                            </tr>
                        @endforeach
                    </tfoot>
                </table>
            </main>
            <footer>
                <h3>COPIA</h3>
                <p class="text-center">Gracias por adquirir nuestros servicios</p>
            </footer>
        </div>
    </div>
    <div style="border-left: 1px dashed black; height: 100vh; position: fixed; margin-left: 49.5%"></div>
</body>
</html>