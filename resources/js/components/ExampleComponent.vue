<template>  
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="mt-4 ml-2 mr-4 mb-4" id="contenido">
            <div class="row text-center">
                <div class="card text-white bg-success col-md-3 mb-4 ml-2 b-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Tasa de Cambio      <span class="fa fa-money fa-2x ml-4"></span></h5>
                        
                        <h3 class="card-text">C$ {{ dolar }}</h3>
                    </div>
                </div>
                <div class="card text-white bg-danger col-md-3 mb-4 ml-2">
                    <div class="card-body">
                        <h5 class="card-title text-center">Cobros <span class="fa fa-group fa-2x ml-4"></span></h5>
                        <h3 class="card-text" v-text="cantidad"></h3>
                    </div>
                </div>
                <div class="card text-white bg-warning col-md-3 mb-4 ml-2">
                    <div class="card-body">
                        <h5 class="card-title text-center">Monto Recolectado <span class="fa fa-suitcase fa-2x"></span></h5>
                        <h3 class="card-text" v-text="total"></h3>
                    </div>
                </div>
                <div class="card text-white bg-info mb-4 ml-2 w-22">
                    <div class="card-body">
                        <h5 class="card-title text-center">Clientes sin cobrar  <span class="fa fa-user-times fa-2x"></span></h5>
                        <h3 class="card-text" v-text="faltante"></h3>
                    </div>
                </div>
            </div>
            <div class="section-contenido">
                <!-- ENCABEZADO -->
                <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                    <h5 class="titulo">Cobros del Día</h5>

                    <!-- buscador -->
                    <div class="buscador d-flex ml-auto hidden-md-down">
                        <label for="" class="etiqueta">Buscar por: </label>
                        <select name="filtro" id="" class="option-search" v-model="criterio">
                            <option value="cl.Nombre">Cliente</option>
                            <option value="b.Nombre">Barrio</option>
                        </select>
                    <input type="text" v-model="buscar" @keypress.enter="cobrosDias(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
                    <div class="icon-buscar">
                        <i class="fa fa-search hidden-md-down"></i>
                    </div> 
                    </div>
                </div>
                <!-- CUERPO -->
                <div class="contenido__cuerpo" id="cuerpo-contenido">
                    <div class="table-responsive tabla-contenido">
                        <!-- Buscar  -->
                        <div class="form-inline mt-2 mb-2">
                            <label for="buscar" class="hidden-lg-up ml-1">Buscar por: </label>
                            <select id="select-opciones" class="custom-select hidden-lg-up mb-1 mr-1 w-25" v-model="criterio">
                                <option value="cl.Nombre">Cliente</option>
                                <option value="b.Nombre">Barrio</option>
                            </select>
                            <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="cobrosDias(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                            <a href="#" style="display: none" id="TasaValid" @click="abrirModal('cobros','tasa')"></a>
                        </div>
                        <!-- TABLA -->
                        <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                            <thead class="enc-tabla">
                                <tr>
                                    <th style="width: 14%">Opciones</th>
                                    <th>Cliente</th>
                                    <th>Dirección</th>
                                    <th>Tipo Doc</th>
                                    <th class="text-center">Abono C$</th>
                                    <th class="text-center">Total C$</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cobro in arraycobros" :key="cobro">
                                    <td>
                                        <button class="boton boton-activar" @click="abrirModal('cobros','registrar', cobro)"><i class="fa fa-money"></i></button>
                                        <button class="boton boton-edit" @click="abrirModal('cobros','actualizar', cobro)"><i class="fa fa-calendar"></i></button>
                                        <button class="boton boton-mirar" @click="abrirModal('cobros','estado', cobro)"><i class="fa fa-line-chart"></i></button>
                                    </td>
                                    <td v-text="cobro.Cliente"></td>
                                    <td>{{cobro.Barrio}}, {{cobro.Direccion}}</td>
                                    <td v-text="cobro.Tipo_Doc"></td>
                                    <td class="text-center" v-text="cobro.Abono"></td>
                                    <td class="text-center" v-text="cobro.Total"></td>
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
                </div>
            </div>
            <!-- Abrir Modal-->
            <div class="modal fade" id="btn-new" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="btn-new" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div :class="btnFuncion == 1 ? 'modal-header bg-success': btnFuncion == 2 ? 'modal-header bg-warning':'modal-header'">
                            <h5 :class="btnFuncion == 3 || btnFuncion == 4 ?'modal-title text-black' :'modal-title text-white'" v-text="tituloModal"></h5>
                            <button class="close" aria-label="Cerrar" @click="cerrarModal()" v-show="btnFuncion != 4">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Agragar o actualizar cliente -->
                            <div class="row" v-if="btnFuncion==1">
                                <div class="col-12 col-lg-12">
                                    <label for="nombre">Cliente: </label>
                                    <input type="text" class="form-control" v-model="cliente" disabled>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="apellido">Cambio C$: </label>
                                    <input type="text" class="form-control" v-model="dolar" disabled>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="apellido">Servicio: </label>
                                    <input type="text" class="form-control" v-model="servicio" disabled>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <label for="telefono">Saldo Pendiente: </label>
                                    <input type="text" class="form-control" v-model="saldo" disabled>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <label for="cedula">Abono Sugerido: </label>
                                    <input type="text" class="form-control" v-model="abonoprom" disabled>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="barrio">Abono C$: </label>
                                    <input type="number" class="form-control" v-model="abono">
                                </div>
                            </div>
                            <!-- Mostrar datos del cliente  -->
                            <div class="row" v-else-if="btnFuncion == 2">
                                <div class="col-md-12">
                                    <label for="">Cliente: </label>
                                    <input type="text" v-model="cliente" class="form-control" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="">F. Cobro Act:</label>
                                    <input type="date" v-model="fechaAct" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="">F. Sig. Cobro:</label>
                                    <input type="date" v-model="fechaSig" :min="fechaAct"  class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Motivo del Cambio:</label>
                                    <input type="text" class="form-control" v-model="motivo">
                                </div>
                            </div>
                            <div class="row" v-else-if="btnFuncion == 3">
                                <div class="table-responsive tabla-contenido">
                                    <!-- TABLA -->
                                    <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                                        <thead class="enc-tabla">
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Descripción</th>
                                                <th class="text-center">Deuda</th>
                                                <th class="text-center">Abono</th>
                                                <th class="text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="est in arrayEstado" :key="est" :style="parseFloat(est.Deuda) > 0?'font-weight: 800' : parseFloat(est.Abono) < 0 ? 'color: red':''">
                                                <td v-text="est.Fecha"></td>
                                                <td v-text="est.Descripcion"></td>
                                                <td class="text-center" v-text="est.Deuda"></td>
                                                <td class="text-center" v-text="est.Abono"></td>
                                                <td class="text-center" v-text="est.TotalRestante"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row" v-else-if="btnFuncion == 4">
                                <div class="col-md-12">
                                    <label for="">Dolar a Cordoba</label>
                                    <input type="number" v-model="tasa" class="form-control">
                                </div>
                            </div>
                            <div v-show="errorFactura" class="form-group msjerror">
                                <div class="text-center texterror" v-for="error in msjErrores" :key="error" v-text="error">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" v-if="btnFuncion == 1" @click="registrarCobro()"><i class="fa fa-check"></i> Guardar</button>
                            <button class="btn btn-warning" v-if="btnFuncion == 2" @click="ActualizarFecha()"><i class="fa fa-check"></i> Actualizar</button>
                            <button class="btn btn-success" v-if="btnFuncion == 4" @click="AgregarTasa()"><i class="fa fa-check"></i> Agregar</button>
                            <button class="btn btn-danger" @click="cerrarModal()" v-show="btnFuncion != 4" id="cerrar"><i class="fa fa-remove"></i> Cerrar</button>
                        </div>    
                    </div>
                </div>
            </div>
            <!-- Fin del modal -->
        </div>
    </section>
</template>

<script>
    export default {
        data(){
            return{
                arraycobros: [],
                cantidad: 0,
                total: 0,
                btnFuncion: 0,
                modal: 0,
                faltante: 0,
                cliente: '',
                abonoprom: 0,
                saldo: 0,
                abono: 0,
                servicio: '',
                idcxc: 0,
                infoTasa: [],
                dolar: '',
                idTasa: 0,
                documento: '',
                numerodoc: 0,
                fechaAct: '',
                fechaSig: '',
                motivo: '',
                idCliente: 0,
                errorFactura: 0,
                msjErrores: [],
                arrayEstado: [],
                rsp: '',
                tasa: 0,
                pagination: {
                    'total': 0,    
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'cl.Nombre',
                buscar: '',
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
            }
        },
        methods: {
            cobrosDias(pagina,buscar,criterio){
                let me = this;
                var url= '/inicio/cobros?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arraycobros= respuesta.cobros.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(pagina,buscar,criterio){
                let me = this;
                me.pagination.current_page = pagina;
                me.cobrosDias(pagina,buscar,criterio);
            },
            cantidadCobrado(){
                let me = this;
                var url= '/inicio/cantidadCob';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.cantidad= respuesta.cantidad[0].cantidad;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            montoCobrado(){
                let me = this;
                var url= '/inicio/montocob';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    if (respuesta.monto[0].Total == null) {
                        me.total = "C$ 0"; 
                    }else{
                        me.total = "C$ " + respuesta.monto[0].Total;   
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cobroFaltante(){
                let me = this;
                var url= '/inicio/faltante';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.faltante= respuesta.faltante[0].TotalCobro;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            DiaActual(){
                let me = this;
                var url= '/inicio/fecha';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                        me.fechaAct = respuesta.fecha;   
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            EstadoCuenta(idContrato){
                let me = this;
                var url= '/inicio/estado?idContrato='+idContrato;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arrayEstado= respuesta.estado;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrirModal(modelo, accion, data=[]){
                switch (modelo) {
                    case "cobros":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.btnFuncion = 1;
                                this.tituloModal = 'Registrar Abono';
                                this.cliente = data["Cliente"];
                                this.abonoprom = data["Abono"];
                                this.saldo = data["Total2"];
                                this.servicio = data["servicio"];
                                this.idcxc = data["idCxC"];
                                this.documento = data["Tipo_Doc"];
                                this.numerodoc = data["numerodoc"];
                                this.idCliente = data["idCliente"];
                                this.mostrarTasaC();
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.DiaActual();
                                this.btnFuncion = 2;
                                this.tituloModal = 'Actualizar Fecha';
                                this.cliente = data["Cliente"];
                                this.idcxc = data["idCxC"];
                                break;
                            }
                            case 'estado':
                            {
                                this.modal = 1;
                                this.EstadoCuenta(data["idcontrato"]);
                                this.btnFuncion = 3;
                                this.tituloModal = 'Estado de Cuenta';
                                break;
                            }
                            case 'tasa':
                            {
                                this.modal = 1;
                                this.btnFuncion = 4;
                                this.tituloModal = 'Tasa de Cambio';
                                break;
                            }
                        }
                    }
                }

                this.cobrosDias(1,me.buscar,me.criterio);
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
            registrarCobro(){
                if(this.validarFrmFactura()){
                    return;
                }
                let me = this;
                axios.post('/factura/registrar', {
                    'idDolar' : this.idTasa, 
                    'idDocumento': this.idcxc,
                    'TipoDocumento': this.documento,
                    'Monto': this.abono,
                    'NumContrato' : this.numerodoc,
                    'Dolar' : me.dolar,
                    'Saldo' : me.saldo,
                    'idCliente' : me.idCliente
                    }).then(function(response) {
                        me.cobrosDias(1,me.buscar,me.criterio);
                        me.cantidadCobrado();
                        me.montoCobrado();
                        me.cobroFaltante();
                        me.cerrarModal();
                    })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarFrmFactura(){
                this.errorFactura=0;
                this.msjErrores= [];

                if(this.abono==0){
                    this.msjErrores.push("*  No puede registrar un abono con 0");
                }
                if(this.msjErrores.length) 
                {
                    this.errorFactura= 1;
                }
                return this.errorFactura;
            },
            ActualizarFecha(){
                let me = this;
                if (me.fechaAct != me.fechaSig) {
                    axios.put('/cxc/actfecha', {
                        'fecha' : me.fechaSig,
                        'id': me.idcxc,
                        'motivo': me.motivo
                        }).then(function(response) {
                            me.cobrosDias(1,me.buscar,me.criterio);
                            me.cantidadCobrado();
                            me.montoCobrado();
                            me.cobroFaltante();
                            me.cerrarModal();
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.msjErrores = [];
                this.errorCliente = 0;
            }, 
            VerificarTasa(){
                let me=this;
                var url = '/inicio/verificar';
                axios.get(url).then(function (response) {
                    var respuesta = response.data; 
                    me.rsp = respuesta.rps[0].respuesta;
                    if (me.rsp == 'NO') {
                        document.getElementById("TasaValid").click();
                    }
                })
                .catch(function (error) {
                    console.log(error);
                })
                this.SeleccionarTasa();
            },
            AgregarTasa(){
                if (this.validarMonto()) {
                    return;
                }
                let me = this;  
                axios.post('/dolar/registrar', {
                    'Cambio' : this.tasa,
                    })
                .then(function (response) {
                    me.SeleccionarTasa();
                    me.rsp = '';
                    me.cerrarModal();
                    document.getElementById("cerrar").click();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarMonto(){
                this.error=0;
                this.txtvalidate = [];

                if(this.tasa == 0) this.txtvalidate.push("El monto no puede ser 0.");
            
                if(this.txtvalidate.length) this.error = 1;

                return this.error;
            },
            SeleccionarTasa(){
                let me=this;
                var url = '/dolar/seleccionar'
                axios.get(url).then(function (response) {
                    var respuesta = response.data; 
                    me.dolar = respuesta.tasa.Monto;
                })
                .catch(function (error) {
                    console.log(error);
                })
            },
        },
        mounted() {
            this.VerificarTasa();
            this.cobrosDias(1, this.buscar, this.criterio);
            this.cantidadCobrado();
            this.montoCobrado();
            this.cobroFaltante();
            //this.validarTasa();
            this.SeleccionarTasa();
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
        background-color: #3c29297a !important;
    }
    .msjerror{
        display: flex;
        justify-content: left;
    }
    .texterror{
        color: red;
        font-weight: bold;
        font-size: 12px;
    } 
    .w-22{
        width: 22%
    }

    @media screen and (max-width: 767px) {
        .w-22{
            width: 100%;
        }
    }
</style>