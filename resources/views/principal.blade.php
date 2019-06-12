<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="css/all.css">
    <title>Funeraria CACHA</title>
</head>
<body>
<div id="app">
    <div class="container-fluid">
        <div class="row">
            <!-- BARRA HORIZONTAL -->
            <header class="barrah hidden-sm-down col-md-10 d-flex ml-auto">
                <div class="col-md-5 barrah__encabezado1">
                    <h5 class="barrah__titulo">Inicio <i class="fa fa-home"></i></h5>
                </div>
                <!-- <div class="boxl"> </div>  -->
               <!--  <div class="boxr"> </div> -->

                <div class="barrah__encabezado2 col-md-5 d-flex ml-auto justify-content-around">
                    <!-- notificaciones -->
                    <a href="#" class="notificacion dropdown-toggle" id="notificacion" data-toggle="dropdown"><i class="fa fa-bell"></i> <small> 5 <span class="hidden-lg-down">Notificaciones</span> </small> </a>
                        <div class="notificacion__contenido dropdown-menu" aria-labelledby="notificacion">
                            <h6 class="notificacion__encabezado dropdown-header"><b>Cobros del Dia</b></h6>
                            <a href="#" class="notificacion__item dropdown-item"><small>Pagado <span class="badge badge-pill badge-danger pull-right">3</span></small></a>
                            <a href="#" class="notificacion__item dropdown-item"><small>No Pagado <span class="badge badge-pill badge-danger pull-right">1</span></small></a>
                            <a href="#" class="notificacion__item dropdown-item"><small>Cambio Fecha <span class="badge badge-pill badge-danger pull-right">1</span></small></a>
                        </div>
                    <h6 class="usuario"><span class="hidden-lg-down">Buenos Dias,</span> Mr. Magnus Cartwright</h6>
                    <a href="#" class="Salir" data-toggle="tooltip" data-placement="bottom" title="Cerrar Sesión"><i class="fa fa-power-off"></i></a>
                </div>
            </header>
            <!-- ENCABEZADO DE LA BARRA VERTICAL-->
            <div class="barrav col-md-2 col-sm-12" id="barra-lateral">
                <div class="bvencabezado d-flex" id="logo">
                    <img src="img/Firefox_48px.png" alt="logo" class="bvencabezado__logo">
                    <h6 class="bvencabezado__titulo"><span class="ocultar-elemento">Funeraria</span> CACHA</h6>
                    <a href="#" class="bvencabezado__menu hidden-md-up mr-3" id="btnMenu"><i class="fa fa-2x fa-bars"></i></a>
                </div>
            <!-- CERRARA SESION DESDE LA CABECERA -->
                <div class="bvsubmenu d-flex hidden-md-up">
                    <div class="bvsubmenu__cuerpo d-flex">
                        <h6 class="usuario"><i class="fa fa-user-circle"></i> Mr. Magnus Cartwright</h6>
                        <a href="#" class="notificacion notificacion--barrav" id="notificacion1" data-toggle="dropdown"><i class="fa fa-bell"></i><small> 5</small>   </a>
                        <div class="dropdown-menu" aria-labelledby="notificacion1">
                            <h6 class="dropdown-header"><b>Cobros del Dia</b></h6>
                            <ul>
                                <li class="dropdown-item"><small>Pagado <span class="badge badge-pill badge-danger pull-right">3</span></small></li>
                                <li class="dropdown-item"><small>No Pagado <span class="badge badge-pill badge-danger pull-right">1</span></small></li>
                                <li class="dropdown-item"><small>Cambio Fecha <span class="badge badge-pill badge-danger pull-right">1</span></small></li>
                            </ul>
                        </div>                        
                    </div>
                    <a href="#" class="Salir Salir--bv mr-3"><i class="fa fa-power-off"></i> Salir</a>
                </div>
            <!-- MENU DE LA BARRA VERTICAL -->
                <nav class="bvmenu d-flex d-sm-block justify-content-center flex-wrap" id="acordion" role="tablist" aria-multiselectable="true">

                    <h5 class="bvmenu__titulo hidden-md-up w-100 d-flex justify-content-center">MENU</h5>

                    <a class="bvmenu__item" href="dashboard.html">
                        <i class="fa fa-dashboard hidden-md-down ocultar-elemento"></i>
                        Dashboard
                    </a>
                    <a class="bvmenu__item" href="#inicio" id="btnInicio" aria-expanded="false" aria-controls="inicio" data-toggle="collapse">
                        <i class="fa fa-home hidden-md-down ocultar-elemento"></i>
                        Inicio
                        <i id="flecha_izq" class="fa fa-angle-right pull-right"></i>
                    </a>
                        <div class="collapse" id="inicio">
                            <ul class="bvmenu__sub">
                                <a class="bvmenu__subitem" href="index.html"><i class="fa fa-circle-o"></i>Opción 1</a>
                                <a class="bvmenu__subitem" href=""><i class="fa fa-circle-o"></i>Opción 2</a>
                                <a class="bvmenu__subitem" href=""><i class="fa fa-circle-o"></i>Opción 3</a>
                            </ul>
                        </div>
                    <a class="bvmenu__item" href="#ubicacion" id="btnUbicacion" aria-expanded="false" aria-controls="ubicacion" data-toggle="collapse">
                        <i class="fa fa-map hidden-md-down ocultar-elemento"></i>
                        Ubicacion
                        <i id="flecha" class="fa fa-angle-right pull-right"></i>
                    </a>
                        <div class="collapse" id="ubicacion">
                            <ul class="bvmenu__sub">
                                <a class="bvmenu__subitem" href=""><i class="fa fa-circle-o"></i>Opción 1</a>
                                <a class="bvmenu__subitem" href=""><i class="fa fa-circle-o"></i>Opción 2</a>
                                <a class="bvmenu__subitem" href=""><i class="fa fa-circle-o"></i>Opción 3</a>
                            </ul>
                        </div>
                    <a class="bvmenu__item" href="#facturacion" id="btnfacturacion" aria-expanded="false" aria-controls="facturacion" data-toggle="collapse">
                        <i class="fa fa-book hidden-md-down ocultar-elemento"></i>
                        Facturacion
                        <i id="flecha1" class="fa fa-angle-right pull-right"></i>
                    </a>
                        <div class="collapse" id="facturacion">
                        <ul class="bvmenu__sub">
                            <a class="bvmenu__subitem" href=""><i class="fa fa-circle-o"></i>Opción 1</a>
                            <a class="bvmenu__subitem" href=""><i class="fa fa-circle-o"></i>Opción 2</a>
                            <a class="bvmenu__subitem" href=""><i class="fa fa-circle-o"></i>Opción 3</a>
                        </ul>
                    </div>
                    <a class="bvmenu__item" href="#">
                        <i class="fa fa-users hidden-md-down ocultar-elemento"></i>
                        Empleados
                    </a>
                    <a  class="bvmenu__item" href="#">
                        <i class="fa fa-question hidden-md-down ocultar-elemento"></i> 
                        Ayuda 
                        <span class="badge badge-danger pull-right">PDF</span>
                    </a>
                </nav>
                <a href="#" class="fondo-enlace hidden-lg-up" id="fondoEnlace"></a>
            </div>

            <!-- CONTENIDO-->
            @yield('contenido')
            {{-- FIN DEL CONTENIDO --}}
        </div>
    </div>
</div>
    <script src="js/all.js"></script>
    <script src="js/app.js"></script>
</body>
</html>