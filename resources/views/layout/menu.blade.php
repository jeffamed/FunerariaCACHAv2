<nav class="bvmenu d-flex d-sm-block justify-content-center flex-wrap" id="acordion" role="tablist" aria-multiselectable="true">

    <h5 class="bvmenu__titulo hidden-md-up w-100 d-flex justify-content-center">MENU</h5>

    <a class="bvmenu__item" href="#" @click="menu=0">
        <i class="fa fa-dashboard hidden-md-down ocultar-elemento"></i>
        Dashboard
    </a>
    <a class="bvmenu__item" href="#cartera" id="btnCartera" aria-expanded="false" aria-controls="cartera" data-toggle="collapse">
        <i class="fa fa-bank hidden-md-down ocultar-elemento"></i>
        Cartera
        <i id="flecha2" class="fa fa-angle-right pull-right"></i>
    </a>
    <div class="collapse" id="cartera">
        <ul class="bvmenu__sub">
            <a class="bvmenu__subitem" href="#" @click="menu=1"><i class="fa fa-circle-o"></i>Factura</a>            
            <a class="bvmenu__subitem" href="#" @click="menu=2"><i class="fa fa-circle-o"></i>Contrato</a>
            <a class="bvmenu__subitem" href="#" @click="menu=3"><i class="fa fa-circle-o"></i>Financiar</a>
        </ul>
    </div>
   <a class="bvmenu__item" href="#inicio" id="btnInicio" aria-expanded="false" aria-controls="inicio" data-toggle="collapse">
        <i class="fa fa-book hidden-md-down ocultar-elemento"></i>
        Catálogo
        <i id="flecha_izq" class="fa fa-angle-right pull-right"></i>
    </a>
    <div class="collapse" id="inicio">
        <ul class="bvmenu__sub">
            <a class="bvmenu__subitem" href="#" @click="menu=4"><i class="fa fa-circle-o"></i>Clientes</a>            
            <a class="bvmenu__subitem" href="#" @click="menu=5"><i class="fa fa-circle-o"></i>Servicios</a>
            <a class="bvmenu__subitem" href="#" @click="menu=6"><i class="fa fa-circle-o"></i>Proyectos</a>
        </ul>
    </div>
    <a class="bvmenu__item" href="#ubicacion" id="btnUbicacion" aria-expanded="false" aria-controls="ubicacion" data-toggle="collapse">
        <i class="fa fa-map hidden-md-down ocultar-elemento"></i>
        Ubicación
        <i id="flecha" class="fa fa-angle-right pull-right"></i>
    </a>
        <div class="collapse" id="ubicacion">
            <ul class="bvmenu__sub">
                <a class="bvmenu__subitem" href="#" @click="menu=7"><i class="fa fa-circle-o"></i>Barrios</a>
                <a class="bvmenu__subitem" href="#" @click="menu=8"><i class="fa fa-circle-o"></i>Zonas</a>
                <a class="bvmenu__subitem" href="#" @click="menu=9"><i class="fa fa-circle-o"></i>Departamentos</a>
                <a class="bvmenu__subitem" href="#" @click="menu=10"><i class="fa fa-circle-o"></i>Municipios</a>
            </ul>
        </div>
    <a class="bvmenu__item" href="#facturacion" id="btnfacturacion" aria-expanded="false" aria-controls="facturacion" data-toggle="collapse">
        <i class="fa fa-users hidden-md-down ocultar-elemento"></i>
        Acceso
        <i id="flecha1" class="fa fa-angle-right pull-right"></i>
    </a>
        <div class="collapse" id="facturacion">
        <ul class="bvmenu__sub">
            <a class="bvmenu__subitem" href="#" @click="menu=11"><i class="fa fa-circle-o"></i>Empleados</a>
            <a class="bvmenu__subitem" href="#" @click="menu=12"><i class="fa fa-circle-o"></i>Usuarios</a>
        </ul>
    </div>

    <a  class="bvmenu__item" href="#" @click="menu=13">
        <i class="fa fa-question hidden-md-down ocultar-elemento"></i> 
        Ayuda 
        <span class="badge badge-danger pull-right">PDF</span>
    </a>
</nav>
<a href="#" class="fondo-enlace hidden-lg-up" id="fondoEnlace"></a>