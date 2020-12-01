<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
              <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Facturar</h5>
                <!-- Boton nuevo -->
                <button class="btn-new"  @click="mostrarFrm('ventas','registrar')" v-if="$can('ventas.store')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
                <!-- buscador -->
                <div class="buscador d-flex ml-auto hidden-md-down">
                    <label for="" class="etiqueta">Buscar por: </label>
                    <select name="filtro" id="" class="option-search" v-model="criterio">
                        <option value="v.id">Factura</option>
                        <option value="c.Nombre">Cliente</option>
                        <!-- <option value="descripcion">Descripción</option> -->
                    </select>
                    <input type="text" v-model="buscar" @keyup="mostrarVentas(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
                    <div class="icon-buscar">
                        <i class="fa fa-search hidden-md-down"></i>
                    </div> 
                </div>
                <!-- Fin del buscador -->
            </div>
            <!-- CUERPO -->
            <div class="contenido__cuerpo" id="cuerpo-contenido">
                <!-- tabla -->
                <template v-if="mostrar == 1">
                    <div class="table-responsive tabla-contenido">
                        <!-- Buscador segundo-->
                        <div class="form-inline mt-2 mb-2">
                            <label for="buscar" class="hidden-lg-up ml-1">Buscar por: </label>
                            <select id="select-opciones" class="custom-select hidden-lg-up mb-1 mr-1 w-25" v-model="criterio">
                                <option value="idDocumento">Factura</option>
                                <!-- <option value="descripcion">Descripción</option> -->
                            </select>
                            <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="mostrarVentas(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                        </div>
                        <!-- fin del buscador segundo -->
                        <!-- TABLA -->
                        <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                            <thead class="enc-tabla">
                                <tr>
                                    <th>Opciones</th>
                                    <th># Factura</th>
                                    <th>Cliente</th>
                                    <th>Monto C$</th>
                                    <th>Fecha</th>
                                    <th>Estados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="venta in Ventas" :key="venta.id" :style="venta.estado=='Facturado'?'':'color:red'">
                                    <td>
                                        <!--<button class="boton boton-edit" @click="abrirModal('factura','actualizar', Factura)"><i class="fa fa-pencil"></i></button>-->
                                        <template v-if="venta.estado == 'Facturado'">
                                            <button class="boton boton-eliminar" @click="desactivarFactura(venta.id)" v-if="$can('ventas.cancel')"><i class="fa fa-trash"></i></button>
                                        </template>
                                        <button class="boton boton-mirar" @click="verDatos(venta.id)"><i class="fa fa-eye"></i></button>
                                    </td>
                                    <td v-text="venta.id"></td>
                                    <td v-text="venta.cliente"></td>
                                    <td class="text-center" v-text="venta.TotalMoney"></td>
                                    <td v-text="venta.created_at"></td>
                                    <td v-text="venta.estado"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- PAGINACION -->
                    <nav aria-label="page navigation example">
                        <ul class="pagination justify-content-end" id="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a href="#" class="page-link" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)"><span>&laquo;</span> Ant</a>
                            </li>
                            <li class="page-item" v-for="pagina in pagesNumber" :key="pagina" :class="page == isActived ? 'active' : ''">
                                <a href="#" class="page-link"  @click.prevent="cambiarPagina(pagina,buscar,criterio)" v-text="pagina"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a href="#" class="page-link" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig <span>&raquo;</span></a>
                            </li>
                        </ul>
                    </nav>
                </template>
                <!-- mostrar formulario -->
                <template v-else-if="mostrar==2">
                    <div class="row m-1">
                        <!-- tasa de cambio -->
                        <div class="col-md-3 form-group">
                            <label for="" class="form-control-label">Cambio ($): </label>
                            <input type="text" class="form-control" readonly v-model="dolar">
                        </div>
                        <!-- Cliente -->
                        <div class="col-md-6 form-group">
                            <label for="" class="form-control-label">Clientes: </label>
                            <v-select 
                                label="Nombre"
                                placeholder="Buscar Cliente.."
                                :options="infoCliente"
                                v-model="idCliente"
                                :reduce="infoCliente => infoCliente.id"
                                @keyup.enter="saltarServicio()"
                            >
                            </v-select>
                        </div>
                    </div>
                    <div class="row m-1">
                        <!-- Servicio -->
                        <div class="col-md-6 form-group">
                            <label for="" class="form-control-label">Servicios: </label>
                            <v-select 
                                label="Nombre"
                                placeholder="Buscar Servicio..."
                                @search="selectServicio"
                                :options="infoServicio"
                                @input="setServicio"
                                v-model="servicios"
                                :value="selectServicio.Nombre"
                                id="idservicio"
                                @keyup.enter="saltarCantidad()"
                            >
                            </v-select>
                        </div>
                        <!-- Cantidad -->
                        <div class="col-md-3 form-group">
                            <label for="" class="form-control-label">Cantidad: </label>
                            <input type="number" class="form-control" id="txtCantidad" min="0" v-model="cantidad" @keyup.enter="saltarCantidad()">
                        </div>
                        <!-- Monto -->
                        <div class="col-md-3 form-group">
                            <label for="" class="form-control-label">Precio C$: </label>
                            <input type="text" class="form-control" disabled v-model="monto">
                        </div>
                    </div>
                    <div class="row m-1">
                        <div class="col-md-10">
                            <label for="" class="form-control-label">Descripción</label>
                            <input type="text" name="" id="txtDescripcion" class="form-control" v-model="descripcion" @keyup.enter="saltarDescripcion()">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success mt-4" @click="agregarDetalle"><span class="fa fa-plus-circle"></span> Agregar</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row m-1">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered table-hover table-striped table-sm">
                                <thead>
                                    <th>Eliminar</th>
                                    <th>Servicio</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Monto C$</th>
                                    <th class="text-center">SubTotal</th>
                                </thead>
                                <tbody v-if="detalleventa.length > 0">
                                    <tr v-for="(det, index) in detalleventa" :key="det.id">
                                        <td style="width: 5%"><button class="boton boton-eliminar" @click="eliminarProd(index)">X</button></td>
                                        <td v-text="det.servicio"></td>
                                        <td class="text-center" v-text="det.cantidad"></td>
                                        <td class="text-center" v-text="det.precio"></td>
                                        <td class="text-center">{{det.cantidad * det.precio}}</td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="5" class="text-center"> *** Agregar un servicio ***</td>
                                    </tr>
                                </tbody>
                                <tfoot v-show="detalleventa.length > 0">
                                    <tr>
                                        <td colspan="4">Total C$:</td>
                                        <td>{{ total = TotalFact.toFixed(2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div v-show="errorFactura" class="form-group msjerror">
                            <div class="col-12 text-center texterror" v-for="error in msjErrores" :key="error" v-text="error"></div>
                        </div>
                    </div>
                    <div class="row m-1">
                        <div class="col-md-12 float-right">
                            <button class="btn btn-danger" @click="mostrarTabla()"><span class="fa fa-close"></span> Cancelar</button>
                            <button class="btn btn-success" @click="registrarVentas()"><span class="fa fa-check"></span> Guardar</button>
                        </div>
                    </div>
                </template>
                <template v-if="mostrar == 3">
                    <div class="row m-1">
                        <div class="col-md-12">
                            <p class="fontperz"><b>Num. Factura: </b>{{idVentas}}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="fontperz"><b>Cliente: </b>{{cliente}}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="fontperz"><b>Total C$: </b>{{total}}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="fontperz"><b>Estado: </b>{{estado}}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="fontperz"><b>Fecha Registro: </b>{{fecha}}</p>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped">
                                <thead >
                                    <tr>
                                        <th>Servicio</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Monto C$</th>
                                        <th class="text-center">SubTotal C$</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="venta in detalleventa" :key="venta">
                                        <td v-text="venta.Nombre"></td>
                                        <td class="text-center" v-text="venta.cantidad"></td>
                                        <td class="text-center" v-text="venta.precios"></td>
                                        <td class="text-center" v-text="venta.Subtotal"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-danger" @click="mostrarTabla"><span class="fa fa-close"></span> Cerrar</button>
                            <button class="btn btn-warning" @click="ImprimirVentas(idVentas)"><span class="fa fa-print"></span> Reimprimir</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
</template>

<script>
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    export default {
        data(){
            return {
                idVentas: 0,
                idTasa: 0,
                idCliente: 0,
                idServicio: 0,
                dolar: 0,
                monto: 0,
                cliente: '',
                Ventas: [],
                infoTasa:[],
                errorFactura: 0,
                informacion: [],
                mostrar: 1,
                msjErrores: [],
                msjVal: [],
                pagination: {
                    'total': 0,    
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'v.id',
                buscar: '',
                infoCliente: [],
                infoServicio: [],
                descripcion: '',
                servicios: '',
                detalleventa: [],
                total: 0,
                estado: '',
                fecha: '',
                cantidad: 0,

            }
        },
        computed: {
            isActived: function(){
                return this.pagination.current_page;
            },
            // Calcular los elementos de la paginacion
            pagesNumber: function() {
                if (!this.pagination.to) {
                    return [];
                }  

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            TotalFact: function(){
                var suma = 0;
                for (let i = 0; i < this.detalleventa.length; i++) {
                    suma = parseFloat(suma) + parseFloat(this.detalleventa[i].cantidad * this.detalleventa[i].precio);
                }
                return suma;
            },
        },
        components:{
            vSelect
        },
        methods:{
            mostrarVentas(pagina,buscar,criterio){
                let me = this;
                var url= '/ventas?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.Ventas = respuesta.ventas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarTasaC(){
                let me = this;
                var url= '/tasa/mostrar';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.infoTasa = respuesta.tasa;
                    me.dolar = me.infoTasa.Monto;
                    me.idTasa = me.infoTasa.id;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarCliente(){
                let me = this;
                var url= '/cliente/seleccionarCliente';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.infoCliente = respuesta.clientes;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            saltarServicio(){
                setTimeout(()=>{
                    document.getElementById("idservicio").find('.vs__search').focus();
                },100)
            },
            saltarCantidad(){
                document.getElementById("txtCantidad").focus().select();
            },
            saltarDescripcion(){
                this.agregarDetalle();
                this.saltarServicio();
            },
            selectServicio(){
                let me = this;
                var url= '/servicio/individual';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.infoServicio = respuesta.servicios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            setServicio(value){
                let me = this;
                me.monto = value.Monto;
                me.descripcion = value.Descripcion;
                me.idServicio = value.id;
                me.servicios = value.Nombre
            },
            encuentra(id){
                var temp = false;
                for (let i = 0; i < this.detalleventa.length; i++) {
                    if (this.detalleventa[i].idservicio == id) {
                        return temp=true;
                    } 
                }
                return temp;
            },
            agregarDetalle(){
                let me = this;
                if (me.encuentra(me.idServicio)) {
                    swal({
                        title: 'Error...',
                        text: "Lo sentimos, ya tiene registrado el producto",
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        showClass: {
                            popup: 'animated fadeInDown faster'
                        },
                        hideClass: {
                            popup: 'animated fadeOutUp faster'
                        }
                    })
                } else {
                    if (me.cantidad>0 && me.idServicio != 0 && me.servicios != '') {
                        me.detalleventa.push({
                            idservicio : me.idServicio,
                            servicio : me.servicios,
                            cantidad : me.cantidad,
                            precio: me.monto
                        })
                        //$('#idservicio').find('.vs__search').focus();
                        me.ClearServicio();
                        this.msjErrores=[];
                        this.errorFactura=0;
                    }else{
                        this.msjErrores=[];
                        this.errorFactura=0;
                        this.msjErrores.push("* Verifique si tiene seleccionado un servicio o la cantidad es mayor a cero");
                        this.errorFactura= 1;
                        return this.errorFactura;
                    }
                }
            },
            eliminarProd(index){
                let me = this;
                me.detalleventa.splice(index, 1);
            },
            ClearServicio(){
                this.idServicio=0;
                this.monto = 0;
                this.cantidad = 1;
                this.servicios = '';
                this.descripcion ='';
            },
            registrarVentas(){
                if(this.validarFrmVentas()){
                    return;
                }
                else{
                    let me = this;
                    axios.post('/ventas/registrar', {
                        'Dolar' : this.dolar, 
                        'idCliente': this.idCliente,
                        'Total': this.total,
                        'data' : me.detalleventa,
                        }).then(function(response) {
                            me.mostrarTabla();
                            me.mostrarVentas(1,'','id');
                            me.ClearServicio();
                            me.detalleventa=[];
                            me.ImprimirVentas(response.data.id);
                            me.notificacion();
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            notificacion(){
                toastr.success('Factura Registrata',{
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            },
            ImprimirVentas(id){
                window.open('http://127.0.0.1:8000/print/factura/'+id);
            },
            validarFrmVentas(){
                this.errorFactura=0;
                this.msjErrores= [];

                if(this.idCliente == 0){
                    this.msjErrores.push("* Seleccione un Cliente");
                }else if(this.detalleventa.length == 0){
                    this.msjErrores.push("* Agregar al menos un servicio");
                }

                if(this.msjErrores.length) 
                {
                    this.errorFactura= 1;
                }
                return this.errorFactura;
            },
            desactivarFactura(id){
                this.id = id;
               Swal.fire({
               title: 'Motivo de la anulación',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off',
                },
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Anular Factura',
                cancelButtonText: 'Cancelar',
                showClass: {
                    popup: 'animated fadeInDown faster'
                },
                hideClass: {
                    popup: 'animated fadeOutUp faster'
                },
                }).then((result) => {
                    if (result.value) {
                    let me = this;
                    axios.put('/ventas/anular', {
                        'id' : this.id,
                        'Motivo' : result.value
                        })
                    .then(function (response) {
                        swal(
                        'Anulado',
                        'Se hizo cambio en otros datos',
                        'Existoso'
                        )
                        me.mostrarVentas(1,'','id');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                    }     
                    
                })
            },
            cambiarPagina(pagina,buscar,criterio){
                let me = this;
                me.pagination.current_page = pagina;
                me.mostrarVentas(pagina,buscar,criterio);
            },
            verDatos(id){
                let me =  this;
                me.mostrar=3;
                me.idVentas = id;
                var url= '/ventas/info?id='+id;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.cliente = respuesta.ventas[0].cliente;
                    me.estado = respuesta.ventas[0].estado;
                    me.total = respuesta.ventas[0].total;
                    me.fecha = respuesta.ventas[0].created_at;
                    me.detalleventa = respuesta.ventas;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            mostrarFrm(modelo,accion,data=[]){
                this.mostrar = 2;
                switch (modelo) {
                    case "venta":
                        switch (accion) {
                            case 'registrar':
                            {
                                this.ClearServicio();
                                this.detalleventa = [];
                                break;
                            }
                        }    

                    }
                this.mostrarTasaC();
                this.mostrarCliente();
                this.selectServicio();
            },
            mostrarTabla(){
                this.mostrar = 1;
                this.ClearServicio();
                this.cliente = '';
                this.idCliente = '';
                this.detalleventa= [];
            },        
        },
        mounted() {
            this.mostrarVentas(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
         width: 100% !important;
         position: absolute !important;
     }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        /* position: absolute !important; */
        background-color: #3a30c2e8 !important;
    }
    .msjerror{
        display: flex;
        flex-direction: column;
        justify-content: left;
        align-content: left;
    }
    .texterror{
        color: red;
        font-weight: bold;
        font-size: 12px;
    }
    .fontperz{
        font-size: 16px;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
