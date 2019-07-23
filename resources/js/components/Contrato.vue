<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Contratos</h5>
            <!-- Boton nuevo -->
                <button class="btn-new"  @click="mostrarFrm('registrar')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
                <!-- buscador -->
                <div class="buscador d-flex ml-auto hidden-md-down">
                    <label for="" class="etiqueta">Buscar por: </label>
                    <select name="filtro" class="option-search" v-model="criterio">
                        <option value="contratos.Contrato"># Contrato</option>
                        <option value="c.Nombre">Cliente</option>
                    </select>
                    <input type="text" v-model="buscar" @keyup="mostrarContrato(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
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
                                <option value="contratos.Contrato"># Contrato</option>
                                <option value="c.Nombre">Cliente</option>
                            </select>
                            <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="mostrarContrato(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                        </div>
                        <!-- fin del buscador segundo -->
                        <!-- TABLA -->
                        <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                            <thead class="enc-tabla">
                                <tr>
                                    <th>Opciones</th>
                                    <th>Contratos</th>
                                    <th>Cliente</th>
                                    <th>Servicio</th>
                                    <th>Fecha Emisión</th>
                                    <th>Estados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="contrato in Contratos" :key="contrato.id" :style="contrato.Estado == 'Suspendido' ? 'color:orange':''">
                                    <td>
                                        <button class="boton boton-edit" @click="mostrarFrm('actualizar', contrato)"><i class="fa fa-pencil"></i></button>
                                        <template v-if="contrato.Estado == 'Activo'">
                                            <button class="boton boton-eliminar" @click="desactivarContrato(contrato.id)"><i class="fa fa-trash"></i></button>
                                        </template>
                                        <template v-else>
                                            <button class="boton boton-activar" @click="activarContrato(contrato.id)"><i class="fa fa-check-circle"></i></button>
                                        </template>
                                    </td>
                                    <td v-text="contrato.Contrato"></td>
                                    <td v-text="contrato.NombreCliente"></td>
                                    <td v-text="contrato.Servicio"></td>
                                    <td v-text="contrato.Fecha_Emision"></td>
                                    <td v-text="contrato.Estado"></td>
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
                <template v-else>
                    <div class="row m-1">
                        <!-- # contrato -->
                        <div class="col-md-3 form-group">
                            <label for="Contrato" class="form-control-label">Contrato: </label>
                            <input type="text" class="form-control" placeholder="# Contrato" v-model="contrato">
                        </div>
                        <!-- Cliente -->
                        <div class="col-md-6 form-group">
                            <label for="Cliente" class="form-control-label">Cliente:</label>
                            <v-select 
                                label="Nombre"
                                placeholder="Buscar Cliente.."
                                :options="infoCliente"
                                v-model="idCliente"
                                :reduce="infoCliente => infoCliente.id"
                            >
                            </v-select>
                        </div>
                        <!-- Fecha de Emision -->
                        <div class="col-md-3 form-group">
                            <label for="FechaE" class="form-control-label">Fecha de Emisión:</label>
                            <input type="date" name="" id="" class="form-control" v-model="fechaEmision">
                        </div>
                        <!-- Servicio -->
                        <div class="col-md-3 form-group">
                            <label for="Servicio" class="form-control-label">Servicio:</label>
                            <!-- :reduce="infoServicio => infoServicio.id" -->
                            <v-select 
                                label="Nombre"
                                placeholder="Buscar Servicio.."
                                :options="infoServicio"
                                v-model="servicio"
                                :value="infoServicio"
                                @input="getDatosServicio"
                            >
                            </v-select>
                        </div>
                        <!-- Vendedor -->
                        <div class="col-md-6 form-group">
                            <label for="Vendedor" class="form-control-label">Vendedor:</label>
                            <v-select 
                                label="Nombre"
                                placeholder="Buscar Vendedor.."
                                :options="infoVendedor"
                                v-model="idVendedor"
                                :reduce="infoVendedor => infoVendedor.id"
                            >
                            </v-select>
                        </div>
                        <!-- Costo del servicio -->
                        <div class="col-md-3 form-group">
                            <label for="Total" class="form-control-label">Costo del Servicio: </label>
                            <input type="text" class="form-control" v-model="total">
                        </div>
                        <!-- Fecha del primer cobro -->
                        <div class="col-md-3 form-group">
                            <label for="FechaC" class="form-control-label">Primer Cobro:</label>
                            <input type="date" class="form-control" v-model="fechaCobro">
                        </div>
                        <!-- Frecuencia de pago -->
                        <div class="col-md-3 form-group">
                            <label for="Frecuencia" class="form-control-label">Frecuencia de Cobro:</label>
                            <div class="d-flex">
                                <input type="number"  min="1" value="1" class="form-control frecuencia frecuencia-numero" v-model="numeroFrecuencia">
                                <select class="form-control frecuencia frecuencia-tipo" v-model="frecuenciaPago">
                                    <option value="" disabled>Seleccione...</option>
                                    <option value="Semana">Semana</option>
                                    <option value="Mes">Mes</option>
                                    <option value="Dia">Día</option>
                                </select>
                            </div>
                        </div>
                        <!-- Cuotas -->
                        <div class="col-md-3 form-group">
                            <label for="Cuota" class="form-control-label">Cuota:</label>
                            <input type="number" name="Cuota" min="0" value="0" class="form-control" v-model="cuota">
                        </div>
                        <!-- Descuento -->
                        <div class="col-md-3 form-group">
                            <label for="Descuento" class="form-control-label">Descuento (%):</label>
                            <input type="number" name="Descuento" min="0" value="0" class="form-control" v-model="descuento">
                        </div>
                        <!-- Beneficiario -->
                        <div class="col-md-6 form-group">
                            <label for="Beneficiario" class="form-control-label">Beneficiario:</label>
                            <textarea name="" id="" class="form-control" v-model="beneficiario"></textarea>
                        </div>
                        <!-- Notas -->
                        <div class="col-md-6 form-group">
                            <label for="Nota" class="form-control-label">Nota:</label>
                            <textarea name="" id="" class="form-control" v-model="nota"></textarea>
                        </div>
                        <div v-show="errorContrato" class="form-group msjerror">
                            <div class="col-12 text-center texterror" v-for="error in msjErrores" :key="error" v-text="error"></div>
                        </div>
                        <div class="mx-2 my-1 col-12">
                            <button class="btn btn-success" v-if="btnFuncion == 1" @click="registrarContrato()"><i class="fa fa-check"></i> Guardar</button>
                            <button class="btn btn-success" v-if="btnFuncion == 2" @click="actualizarContrato()"><i class="fa fa-check"></i> Actualizar</button>
                            <button @click="mostrarTabla()" class="btn btn-danger"><i class="fa fa-close"></i> Cerrar</button>
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
                idContrato: 0,
                contrato: '',
                idCliente: '',
                idVendedor: '',
                idServicio: '',
                total: 0,
                servicio: '',
                frecuenciaPago : '',
                numeroFrecuencia: 0,
                fechaEmision: '',
                fechaCobro: '',
                descuento: 0,
                beneficiario: '',
                nota: '',
                cuota: 0,
				mostrar: 1,
                Contratos: [],
                infoVendedor: [],
                infoCliente: [],
                infoServicio: [],
                fechaS: '',
                modal: 0,
                tituloModal: '',
                btnFuncion: 0,
                errorContrato: 0,
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
                criterio: 'contratos.Contrato',
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
        components:{
            vSelect
        },
        methods:{
            mostrarContrato(pagina,buscar,criterio){
                let me = this;
                var url= '/contrato?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.Contratos = respuesta.contratos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarVendedor(){
                let me = this;
                // loading(true)
                var url= '/empleado/seleccionarEmpleado';
                axios.get(url).then(function(response) {
                    let respuesta = response.data;
                    // q: search
                    me.infoVendedor = respuesta.empleados;
                    // loading(false);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarCliente(){
                let me = this;
                var url= '/cliente/seleccionarCliente';
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.infoCliente = respuesta.clientes;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarServicio(){
                let me = this;
                var url= '/servicio/seleccionarServicio';
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.infoServicio = respuesta.servicios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosServicio(value){
                let me = this;
                me.loading = true;
                // me.servicio= value.Nombre;
                me.total = value.Monto;
                me.idServicio = value.id;
            },
            mostrarTabla(){
                this.mostrar = 1;
                this.tituloModal = '';
                this.contrato = '',
                this.idCliente = '';
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
                this.msjErrores = [];
                this.errorContrato = 0;
            },
            mostrarFrm(accion,data=[]){
                this.mostrar = 2;
                switch (accion) {
                    case 'registrar':
                    {
                        // this.modal = 1;
                        this.tituloModal = 'Registrar Contrato';
                        this.btnFuncion = 1;
                        this.contrato = '',
                        this.idCliente = '';
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
                        this.tituloModal = 'Actualizar Contrato';
                        this.btnFuncion = 2;
                        this.idContrato = data['id'];
                        this.contrato = data['Contrato'],
                        this.idCliente = data['idCliente'];
                        this.idVendedor = data['idVendedor'];
                        this.idServicio = data['idServicio'];
                        this.servicio = data['Servicio']
                        this.total = data['Total'];
                        this.frecuenciaPago = data['Frecuencia_Pago'];
                        this.fechaEmision = data['Fecha_Emision'];
                        this.numeroFrecuencia = data['Numero_Frecuencia'];
                        this.descuento = data['Descuento'];
                        this.beneficiario = data['Beneficiarios'];
                        this.nota = data['Nota'];
                        this.cuota = data['Cuota'];
						
                        this.fechaCobro = data['FechaCobro'];
                        break;
                    }
                    
                }
            },
            cambiarPagina(pagina,buscar,criterio){
                let me = this;
                me.pagination.current_page = pagina;
                me.mostrarContrato(pagina,buscar,criterio);
            },
            registrarContrato(){
                if(this.validarFrmContrato()){
                    return;
                }
                else{
                    let me = this;
                    axios.post('/contrato/registrar', {
                        'Contrato' : this.contrato,
                        'idCliente' : this.idCliente,
                        'idVendedor' : this.idVendedor,
                        'idServicio' : this.idServicio,
                        'Total' : this.total,
                        'Fecha_Emision' : this.fechaEmision,
                        'Frecuencia_Pago': this.frecuenciaPago,
                        'Numero_Frecuencia': this.numeroFrecuencia,
                        'Descuento' : this.descuento,
                        'Beneficiarios' : this.beneficiario,
                        'Nota' : this.nota,
                        'Cuota' : this.cuota,
						'Fecha_Cobro': this.fechaCobro
                        }).then(function(response) {
                        me.mostrarTabla();
                        me.mostrarContrato(1,'','Contrato');
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            actualizarContrato(){
                if(this.validarFrmContrato()){
                    return;
                }
                else{
                    let me = this;
                    axios.put('/contrato/actualizar', {
                        'id' : this.idContrato,
						
                        'Contrato' : this.contrato,
                        'idCliente' : this.idCliente,
                        'idVendedor' : this.idVendedor,
                        'idServicio' : this.idServicio,
                        'Total' : this.total,
                        'Fecha_Emision' : this.fechaEmision,
                        'Frecuencia_Pago': this.frecuenciaPago,
                        'Numero_Frecuencia': this.numeroFrecuencia,
                        'Descuento' : this.descuento,
                        'Beneficiarios' : this.beneficiario,
                        'Nota' : this.nota,
                        'Cuota' : this.cuota,
                        'Fecha_Cobro': this.fechaCobro
                        }).then(function(response) {
                         me.mostrarTabla();
                        me.mostrarContrato(1,'','Contrato');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
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
            validarFrmContrato(){
                this.errorContrato=0;
                this.msjErrores= [];
                
                if(this.contrato == ''){
                    this.msjErrores.push("* El campo contrato no puede estar vacío");
                }else if(this.idCliente == ''){
                    this.msjErrores.push("* Debe de seleccionar una opción en cliente");
                }else if(this.fechaEmision == ''){
                    this.msjErrores.push("* El campo fecha de emisión no puede estar vacío");
                }else if(this.fechaEmision > this.fechaS){
                    this.msjErrores.push("* El campo fecha de emisión no puede ser mayor a la fecha del sistema");
                }else if(this.idServicio == ''){
                    this.msjErrores.push("* Debe de seleccionar una opción en servicio");
                }else if(this.idVendedor == ''){
                    this.msjErrores.push("* Debe de seleccionar una opción en vendedor");
                }else if(this.fechaCobro == ''){
                    this.msjErrores.push("* El campo fecha de cobro no puede estar vacío");
                }else if(this.fechaCobro <= this.fechaEmision){
                    this.msjErrores.push("La fecha de cobro no puede ser menor a la fecha del registro del contrato")
                }else if(this.numeroFrecuencia <= 0){
                    this.msjErrores.push("* El campo frecuencia de pago tiene que se mayor a 0");
                }else if(this.frecuenciaPago == ''){
                    this.msjErrores.push("* Debe de seleccionar una opción en el campo frecuencia de pago ");
                }else if(this.total < 0){
                    this.msjErrores.push("* El campo total no puede ser negativo");
                }else if(this.descuento < 0){
                    this.msjErrores.push("* El campo descuento no puede ser negativo");
                }else if(this.cuota <= 0){
                    this.msjErrores.push("* El campo cuota no puede ser negativo o igual a 0");
                }else if(this.beneficiario == ''){
                    this.msjErrores.push("* El campo beneficiario no puede estrar vacío");
                }

                if(this.msjErrores.length) 
                {
                    this.errorContrato= 1;
                }
                return this.errorContrato;
            },
            activarContrato(id){
                swal({
                    title: '¿Estas seguro?',
                    text: 'Deseas activar este Contrato',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Activar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true,
                    }).then((result) => {
                        if (result.value) {
                            let me = this;
                            axios.put('/contrato/activar', {'id' : id}).then(function(response) {
                                me.mostrarContrato(1,'','Contrato');
                                swal(
                                    'Activado',
                                    'El registro fue activado correctamente',
                                    'success'
                                )
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        }else if(result.dismiss === swal.DismissReason.cancel){
                        }
                    })
            },
            desactivarContrato(id){
                swal({
                    title: '¿Estas seguro?',
                    text: 'Deseas suspender este contrato',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Desactivar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true,
                    }).then((result) => {
                        if (result.value) {
                            let me = this;
                            axios.put('/contrato/suspender', {'id' : id}).then(function(response) {
                                me.mostrarContrato(1,'','Contrato');
                                swal(
                                    'Suspendido',
                                    'El registro fue suspendido correctamente',
                                    'success'
                                )
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        }else if(result.dismiss === swal.DismissReason.cancel){
                        }
                    })
            },      
        },
        mounted() {
            this.mostrarContrato(1,this.buscar,this.criterio);
            this.mostrarVendedor();
            this.mostrarCliente();
            this.mostrarServicio();
            this.fechaSistema();
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
        justify-content: center;
    }
    .texterror{
        color: red;
        font-weight: bold;
        font-size: 12px;
    }
</style>
