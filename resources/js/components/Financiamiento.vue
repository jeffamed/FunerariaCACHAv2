<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Financiamientos</h5>
                <!-- Boton nuevo -->
                <button class="btn-new"  @click="mostrarFrm('financiar','registrar')" v-if="$can('financiamiento.index')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
                <!-- buscador -->
                <div class="buscador d-flex ml-auto hidden-md-down">
                    <label for="" class="etiqueta">Buscar por: </label>
                    <select name="filtro" id="" class="option-search" v-model="criterio">
                        <option value="f.Financiamiento"># Financiamiento</option>
                        <option value="cl.Nombre">Cliente</option>
                    </select>
                    <input type="text" v-model="buscar" @keyup="mostrarFinanciamiento(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
                    <div class="icon-buscar">
                        <i class="fa fa-search hidden-md-down"></i>
                    </div> 
                </div>
                <!-- Fin del buscador -->
            </div>
            <!-- CUERPO -->
            <div class="contenido__cuerpo" id="cuerpo-contenido">
                <!-- mostrar tabla -->
                <template v-if="mostrar == 1">
                    <div class="table-responsive tabla-contenido">
                        <!-- Buscador segundo-->
                        <div class="form-inline mt-2 mb-2">
                            <label for="buscar" class="hidden-lg-up ml-1">Buscar por: </label>
                            <select id="select-opciones" class="custom-select hidden-lg-up mb-1 mr-1 w-25" v-model="criterio">
                                <option value="f.Financiamiento"># Financiamiento</option>
                                <option value="cl.Nombre">Cliente</option>
                            </select>
                            <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="mostrarFinanciamiento(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                        </div>
                        <!-- fin del buscador segundo -->
                        <!-- TABLA -->
                        <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                            <thead class="enc-tabla">
                                <tr>
                                    <th>Opciones</th>
                                    <th>Financiamiento</th>
                                    <th>Cliente</th>
                                    <th class="text-center">Deuda C$</th>
                                    <th>Estados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="financiamiento in Financiamientos" :key="financiamiento.id" :style="financiamiento.Estado=='Activo'?'':'color:red'">
                                    <td>
                                        <button class="boton boton-edit" @click="mostrarFrm('financiar','actualizar', financiamiento)" v-if="$can('financiamiento.update')"><i class="fa fa-pencil"></i></button>
                                        <button class="boton boton-mirar" @click="mostrardatos(financiamiento.id)"><i class="fa fa-eye"></i></button>
                                    </td>
                                    <td v-text="financiamiento.id"></td>
                                    <td v-text="financiamiento.Cliente"></td>
                                    <td class="text-center" v-text="financiamiento.Totales"></td>
                                    <td v-text="financiamiento.Estado"></td>
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
                <!-- mostrar Formulario -->
                <template v-else-if="mostrar==2">
                    <div class="row m-1">
                        <!-- # Financiamiento -->
                        <!--<div class="col-md-3 form-group">
                            <label for="" class="form-control-label">No. Financiamiento: </label>
                            <input type="text" class="form-control" placeholder="# Financiamiento" v-model="financiamiento">
                        </div>-->
                        <!-- Contrato-->
                        <div class="col-md-3 form-group">
                            <label for="" class="form-control-label"># Contrato:</label>
                                <!-- :reduce="infoContrato => infoContrato.id" -->
                            <v-select 
                                label="Contrato"
                                placeholder="Buscar Contrato.."
                                :options="infoContrato"
                                v-model="contrato"
                                :value="infoContrato"
                                @input="getDatosContrato"
                            >
                            </v-select>
                        </div>
                        <!-- cliente -->
                        <div class="col-md-6 form-group">
                            <label for="cliente" class="form-control-label">Cliente: </label>
                            <input type="text" class="form-control" v-model="nombreCliente" readonly>
                        </div>
                        <!-- saldo para Financear -->
                        <div class="col-md-3 form-group">
                            <label for="Total" class="form-control-label">Saldo Financ.: </label>
                            <input type="text" class="form-control" v-model="saldof" readonly placeholder="Subtotal Financiamiento">
                        </div>
                        <!-- subTotal -->
                        <div class="col-md-4 form-group">
                            <label for="Total" class="form-control-label">Subtotal: </label>
                            <input type="text" class="form-control" v-model="subTotal" readonly placeholder="Subtotal Financiamiento">
                        </div>
                        <!-- saldo para Financear -->
                        <div class="col-md-2 form-group">
                            <label for="Total" class="form-control-label">Monto Fact.: </label>
                            <input type="text" class="form-control" v-model="montofact" readonly placeholder="Subtotal Financiamiento">
                        </div>
                        <!-- % del Financiamiento -->
                        <div class="col-md-2 form-group">
                            <label for="FechaC" class="form-control-label">Financiar %:</label>
                            <input type="number" class="form-control" min="0" v-model="porcentaje" step="0.1" @keydown="FncTotal()" @click="FncTotal()">
                        </div>
                        <!-- total -->
                        <div class="col-md-4 form-group">
                            <label for="" class="form-control-label">Total:</label>
                            <input type="text" class="form-control" readonly v-model="total">
                        </div>
                        <!-- Frecuencia de pago -->
                        <div class="col-md-4 form-group">
                            <label for="Frecuencia" class="form-control-label">Frecuencia de Cobro:</label>
                            <div class="d-flex">
                                <input type="number"  min="1" class="form-control frecuencia frecuencia-numero" v-model="numeroFrecuencia" @click="FncTotal()">
                                <select class="form-control frecuencia frecuencia-tipo" v-model="frecuenciaPago" @click="FncTotal()">
                                    <option value="" disabled>Seleccione...</option>
                                    <option value="Semana">Semana</option>
                                    <option value="Mes">Mes</option>
                                    <option value="Dia">Día</option>
                                </select>
                            </div>
                        </div>
                        <!-- Cuotas -->
                        <div class="col-md-4 form-group">
                            <label for="Cuota" class="form-control-label">Cuota:</label>
                            <input type="number" name="Cuota" min="0" class="form-control" v-model="cuota" @click="FncTotal()">
                        </div>
                        <!-- Fecha del primer cobro -->
                        <div class="col-md-4 form-group">
                            <label for="FechaC" class="form-control-label">Primer Cobro:</label>
                            <input type="date" class="form-control" v-model="fechaCobro" @click="FncTotal()">
                        </div>
                        <div v-show="errorFinanciamiento" class="form-group msjerror">
                            <div class="col-12 text-center texterror" v-for="error in msjErrores" :key="error" v-text="error"></div>
                        </div>
                        <div class="mx-2 my-1 col-12">
                            <button class="btn btn-success" v-if="btnFuncion == 1" @click="registrarFinanciamiento()"><i class="fa fa-check"></i> Guardar</button>
                            <button class="btn btn-warning" v-if="btnFuncion == 2" @click="actualizarFinanciamiento()"><i class="fa fa-check"></i> Actualizar</button>
                            <button @click="mostrarTabla()" class="btn btn-danger"><i class="fa fa-close"></i> Cerrar</button>
                        </div>
                    </div>
                </template>
                <template v-if="mostrar == 3">
                    <div class="row m-1">
                        <div style="border-top: 1px solid gray; border-bottom: 1px solid gray;" class="col-md-12">
                            <label class="text-center d-block">Información del Cliente</label>
                        </div>
                        <div class="col-md-6">
                            <p><b>Cliente:</b> {{nombreCliente}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>No.Cédula:</b> {{cedula}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Teléfono:</b> {{telefono}}</p>
                        </div>
                        <div class="col-md-12">
                            <p><b>Dirección:</b> {{direccion}}</p>
                        </div>
                        <div style="border-top: 1px solid gray; border-bottom: 1px solid gray;" class="col-md-12">
                            <label class="text-center d-block">Información del Financiamiento</label>
                        </div>
                        <div class="col-md-6">
                            <p><b>No.Financiamiento:</b> {{financiamiento}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>No.Contrato:</b> {{contrato}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Proyecto:</b> {{proyecto}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Servicio:</b> {{servicio}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Financeado:</b> C${{subTotal}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Total Deuda:</b> C${{total}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>% Financeado:</b> {{porcentaje}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Cuota:</b> {{cuota}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Frecuencia Pago:</b> {{frecuenciaPago}}</p>
                        </div>
                        <div class="col-md-12">
                            <buttom class="btn btn-danger" @click="mostrarTabla"> Cerrar</buttom>
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
                idFinanciamiento: 0,
                financiamiento: '',
                idContrato: 0,
                nombreCliente: '',
                subTotal: 0,
                porcentaje: 2.5,
                total: 0,
                totalC: 0,
                frecuenciaPago: '',
                numeroFrecuencia: 0,
                cuota: 0,
                fechaPago: 0,
                fechaCobro: 0,
                Financiamientos: [],
                infoContrato: [],
                modal: 0,
                tituloModal: '',
                btnFuncion: 0,
                mostrar: 1,
                errorFinanciamiento: 0,
                msjErrores: [],
                pagination: {
                    'total': 0,    
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'f.Financiamiento',
                buscar: '',
                contrato: '',
                saldof: 0,
                montofact: 0,
                servicio: '',
                proyecto: '',
                direccion: '',
                telefono: '',
                cedula: ''
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
        components : {
            vSelect
        },
        methods:{
            mostrarFinanciamiento(pagina,buscar,criterio){
                let me = this;
                var url= '/financiamiento?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.Financiamientos = respuesta.financiamientos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarContrato(){
                let me = this;
                var url= '/contrato/seleccionarContrato';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.infoContrato = respuesta.contratos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
            getDatosContrato(value){
                let me = this;
                me.loading = true;
                me.nombreCliente = value.NombreCliente;
                me.subTotal = value.SaldoR;
                me.total = parseFloat(value.SaldoR) * 1.025;
                me.totalC = value.total;
                me.idContrato = value.id;
                me.contrato = value.Contrato;
                me.saldof = value.Monto * 0.6;
                if (parseFloat(me.subTotal) == parseFloat(me.saldof)) {
                    me.montofact = 0;
                } else{
                    me.montofact = me.subTotal - me.saldof;
                }
            },
            registrarFinanciamiento(){
                if(this.validarFrmFinanciamiento()){
                    return;
                }
                else{
                    let me = this;
                    axios.post('/financiamiento/registrar', {
                        'idContrato' : this.idContrato,
                        'financiamiento' : this.financiamiento,
                        'PorcentajeFin' : this.porcentaje,
                        'subTotal' : this.subTotal,
                        'Total' : this.total,
                        'Frecuencia_Pago' : this.frecuenciaPago,
                        'Numero_Frecuencia' : this.numeroFrecuencia,
                        'Cuota' : this.cuota,
                        'Fecha_Cobro' : this.fechaCobro
                        }).then(function(response) {
                            me.mostrarTabla();
                            me.mostrarFinanciamiento(1,'','f.Financiamiento');
                            me.notificacion();
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            notificacion(){
                toastr.success('Financiamiento Registrato',{
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
            actualizarFinanciamiento(){
                if(this.validarFrmFinanciamiento()){
                    return;
                }
                else{
                    let me = this;
                    axios.put('/financiamiento/actualizar', {
                        'id' : this.idFinanciamiento,
                        'idContrato' : this.idContrato,
                        'PorcentajeFin' : this.porcentaje,
                        'subTotal' : this.subTotal,
                        'Total' : this.total,
                        'Frecuencia_Pago' : this.frecuenciaPago,
                        'Numero_Frecuencia' : this.numeroFrecuencia,
                        'Cuota' : this.cuota,
                        'Fecha_Cobro' : this.fechaCobro 
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarFinanciamiento(1,'','f.Financiamiento');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            validarFrmFinanciamiento(){
                this.errorFinanciamiento=0;
                this.msjErrores= [];
                let minimo = parseFloat(this.totalC) - (parseFloat(this.totalC) * parseFloat(0.4));
                
                if(this.idContro == 0){
                    this.msjErrores.push("* Elija un contrato");
                }else if(this.fechaPago = ''){
                    this.msjErrores.push("* La fecha no puede estar vacio");
                }else if(this.fechaPago < this.fechaS){
                    this.msjErrores.push("* El campo fecha de emisión no puede ser menor a la fecha del sistema");
                }else if(this.numeroFrecuencia <= 0){
                    this.msjErrores.push("* El campo frecuencia de cobro tiene que se menor a 0");
                }else if(this.frecuenciaPago == ''){
                    this.msjErrores.push("* Debe de seleccionar una opción en el campo frecuencia de cobro");
                }else if(this.total < 0){
                    this.msjErrores.push("* El campo total no puede ser negativo. Agregue un digito en financiar");
                }else if(this.descuento < 0){
                    this.msjErrores.push("* El campo descuento no puede ser negativo");
                }else if(this.cuota <= 0){
                    this.msjErrores.push("* El campo cuota no puede ser negativo o igual a 0");
                }else if(this.subTotal == 0){
                    this.msjErrores.push("* El campo subTotal puede ser 0. Seleccione un contrato");
                }else if(this.total == 0){
                    this.msjErrores.push("* El campo total de descuento no puede ser 0");
                }else if(this.porcentaje == 0){
                    this.msjErrores.push("* El campo porcentaje de descuento no puede ser 0");
                }else if(this.subTotal > minimo){
                    this.msjErrores.push("* Debe de pagar al menos el 40% del servicio para realizar el financiamiento");
                }

                if(this.msjErrores.length) 
                {
                    this.errorFinanciamiento= 1;
                }
                return this.errorFinanciamiento;
            },
            FncTotal(){
                let me = this;
                // let convertir = me.porcentaje.replace(".",",");
                // me.porcentaje = parseFloat(convertir);
                me.total= parseFloat(me.subTotal) + (parseFloat(me.subTotal) * parseFloat(me.porcentaje/100));
            },
            fechaSistema(){
                var f = new Date();
                var day = f.getDate();
                var month = f.getMonth();
                var mes= parseInt(month) + parseInt(1);
                if (mes==13) mes=1;
                if (day < 10)  day= '0' + day;
                if (month < 10)  month= '0' + mes;
                this.fechaS = f.getFullYear()+"-"+month+"-"+ day;
            },
            mostrarTabla(){
                this.mostrar = 1;
                this.tituloModal = '';
                this.idFinanciamiento = 0;
                this.financiamiento = '',
                this.idContrato = 0;
                this.nombreCliente = '';
                this.subTotal = 0;
                this.total = 0;
                this.totalC = 0;
                this.frecuenciaPago = '';
                this.numeroFrecuencia = 0;
                this.porcentaje = 2.5;
                this.cuota = 0;
                this.msjErrores = [];
                this.errorFinanciamiento = 0;
            },
            mostrarFrm(modelo,accion,data=[]){
                this.mostrar = 2;
                switch (modelo) {
                    case "financiar":
                        switch (accion) {
                            case 'registrar':
                            {
                                // this.modal = 1;
                                this.tituloModal = 'Registrar Financiamiento';
                                this.btnFuncion = 1;
                                this.Financiamiento = '',
                                this.idnombreCliente = '';
                                this.idVendedor = '';
                                this.idServicio = '';
                                this.total = 0;
                                this.frecuenciaPago = '';
                                this.fechaEmision = '';
                                this.fechaCobro = '';
                                this.numeroFrecuencia = 0;
                                this.descuento = 0;
                                this.beneficiario = '';
                                this.nota = '';
                                this.cuota = 0;
                                break;
                            }
                            case 'actualizar':
                            {
                                // this.modal = 1;
                                this.btnFuncion = 2;
                                this.tituloModal = 'Actualizar Financiamiento';
                                this.idFinanciamiento = data['id'];
                                this.Financiamiento = data['Financiamiento'],
                                this.idnombreCliente = data['idnombreCliente'];
                                this.idVendedor = data['idVendedor'];
                                this.idServicio = data['idServicio'];
                                this.servicio = data['Servicio']
                                this.total = data['Total'];
                                this.frecuenciaPago = data['Frecuencia_Pago'];
                                this.fechaEmision = data['Fecha_Emision'];
                                this.numeroFrecuencia = data['numero_Frec'];
                                this.descuento = data['Descuento'];
                                this.beneficiario = data['Beneficiarios'];
                                this.nota = data['Nota'];
                                this.cuota = data['Cuota'];
                                this.fechaCobro = data['FechaCobro'];
                                this.nombreCliente = data['Cliente'];
                                this.contrato = data['Contrato']
                                break;
                            }
                    }    

                }
                this.mostrarContrato();
                
            },
            mostrardatos(id){
                let me = this;
                me.mostrar = 3;
                me.idFactura =  id;
                var url= '/financiamiento/informacion?idFin='+id;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.contrato = respuesta.informacion[0].Contrato;
                    me.nombreCliente = respuesta.informacion[0].Cliente;
                    me.frecuenciaPago = respuesta.informacion[0].Frecuencia_Pago;
                    me.cuota = respuesta.informacion[0].Cuota;
                    me.total = respuesta.informacion[0].Total;      
                    me.subTotal = respuesta.informacion[0].SubTotal;    
                    me.porcentaje = respuesta.informacion[0].PorcentajeFin;    
                    me.financiamiento = respuesta.informacion[0].id;    
                    me.servicio = respuesta.informacion[0].Servicio;
                    me.proyecto = respuesta.informacion[0].Proyecto;
                    me.direccion = respuesta.informacion[0].Direccion;
                    me.telefono = respuesta.informacion[0].Telefono;
                    me.cedula = respuesta.informacion[0].Cedula;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(pagina,buscar,criterio){
                let me = this;
                me.pagination.current_page = pagina;
                me.mostrarFinanciamiento(pagina,buscar,criterio);
            },      
        },
        mounted() {
            this.mostrarFinanciamiento(1,this.buscar,this.criterio);
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
        flex-direction: column;
        justify-content: left;
        align-content: left;
    }
    .texterror{
        color: red;
        font-weight: bold;
        font-size: 12px;
    }
</style>
