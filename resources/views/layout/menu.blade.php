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
            @can('factura.index')
                <a class="bvmenu__subitem" href="#" @click="menu=1"><i class="fa fa-circle-o"></i>Recibo</a>            
            @endcan
            @can('contrato.index')
                <a class="bvmenu__subitem" href="#" @click="menu=2"><i class="fa fa-circle-o"></i>Contrato</a>
            @endcan
            @can('financiamiento.index')
                <a class="bvmenu__subitem" href="#" @click="menu=3"><i class="fa fa-circle-o"></i>Financiar</a>
            @endcan
            @can('ventas.index')
                <a class="bvmenu__subitem" href="#" @click="menu=14"><i class="fa fa-circle-o"></i>Facturar</a>
            @endcan
            <a class="bvmenu__subitem" href="#" @click="menu=16"><i class="fa fa-circle-o"></i>Estado Cuenta</a>
        </ul>
    </div>
   <a class="bvmenu__item" href="#inicio" id="btnInicio" aria-expanded="false" aria-controls="inicio" data-toggle="collapse">
        <i class="fa fa-book hidden-md-down ocultar-elemento"></i>
        Catálogo
        <i id="flecha_izq" class="fa fa-angle-right pull-right"></i>
    </a>
    <div class="collapse" id="inicio">
        <ul class="bvmenu__sub">
            @can('cliente.index')
                <a class="bvmenu__subitem" href="#" @click="menu=4"><i class="fa fa-circle-o"></i>Clientes</a>            
            @endcan
            @can('servicio.index')
                <a class="bvmenu__subitem" href="#" @click="menu=5"><i class="fa fa-circle-o"></i>Servicios</a>
            @endcan
            @can('proyecto.index')
                <a class="bvmenu__subitem" href="#" @click="menu=6"><i class="fa fa-circle-o"></i>Proyectos</a>
            @endcan
            @can('cambio.index')
                <a class="bvmenu__subitem" href="#" @click="menu=17"><i class="fa fa-circle-o"></i>Tasa de Cambio</a>
            @endcan
        </ul>
    </div>
    <a class="bvmenu__item" href="#ubicacion" id="btnUbicacion" aria-expanded="false" aria-controls="ubicacion" data-toggle="collapse">
        <i class="fa fa-map hidden-md-down ocultar-elemento"></i>
        Ubicación
        <i id="flecha" class="fa fa-angle-right pull-right"></i>
    </a>
        <div class="collapse" id="ubicacion">
            <ul class="bvmenu__sub">
                @can('barrio.index')
                    <a class="bvmenu__subitem" href="#" @click="menu=7"><i class="fa fa-circle-o"></i>Barrios</a>
                @endcan
                @can('zona.index')
                    <a class="bvmenu__subitem" href="#" @click="menu=8"><i class="fa fa-circle-o"></i>Zonas</a>
                @endcan
                @can('departamento.index')
                    <a class="bvmenu__subitem" href="#" @click="menu=9"><i class="fa fa-circle-o"></i>Departamentos</a>
                @endcan
                @can('municipio.index')
                    <a class="bvmenu__subitem" href="#" @click="menu=10"><i class="fa fa-circle-o"></i>Municipios</a>
                @endcan
            </ul>
        </div>
    <a class="bvmenu__item" href="#facturacion" id="btnfacturacion" aria-expanded="false" aria-controls="facturacion" data-toggle="collapse">
        <i class="fa fa-users hidden-md-down ocultar-elemento"></i>
        Acceso
        <i id="flecha1" class="fa fa-angle-right pull-right"></i>
    </a>
        <div class="collapse" id="facturacion">
        <ul class="bvmenu__sub">
            @can('empleado.index')
                <a class="bvmenu__subitem" href="#" @click="menu=11"><i class="fa fa-circle-o"></i>Empleados</a>
            @endcan
            @can('acceso.index')
                <a class="bvmenu__subitem" href="#" @click="menu=12"><i class="fa fa-circle-o"></i>Usuarios</a>
            @endcan
            @can('rol.index')
            <a class="bvmenu__subitem" href="#" @click="menu=15"><i class="fa fa-circle-o"></i>Roles</a>
            @endcan
        </ul>
    </div>

    <a  class="bvmenu__item" href="#" @click="menu=13">
        <i class="fa fa-book hidden-md-down ocultar-elemento"></i> 
        Reportes
        <span class="badge badge-danger pull-right">PDF</span>
    </a>
</nav>
<a href="#" class="fondo-enlace hidden-lg-up" id="fondoEnlace"></a>