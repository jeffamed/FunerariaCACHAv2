<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Contratos</h5>
            <!-- Boton nuevo -->
                <!-- <button class="btn-new"  @click="mostrarFrm('registrar')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button> -->
                <button class="btn-new"  @click="abrirModal('contrato','registrar')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
                <!-- Abrir Modal-->
                <div class="modal fade" id="btn-new" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="btn-new" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-white" v-text="tituloModal"></h5>
                                <button class="close" aria-label="Cerrar" @click="cerrarModal()">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="row" v-if="btnFuncion!=3">
                                        <div class="col-6">
                                            <label for="Contrato">Contrato: </label>
                                            <input type="text" class="form-control" placeholder="No. Contrato" v-model="contrato">
                                        </div>
                                        <div class="col-6">
                                            <label for="Cliente">Cliente: </label>
                                            <select class="form-control" v-model="idCliente">
                                                <option value="0" disabled>Seleccione...</option>
                                                <option v-for="cliente in infoCliente" :key="cliente.id" :value="cliente.id" v-text="cliente.Nombre"></option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="Vendedor">Vendedor: </label>
                                            <select class="form-control" v-model="idVendedor">
                                                <option value="0" disabled>Seleccione...</option>
                                                <option v-for="vendedor in infoVendedor" :key="vendedor.id" :value="vendedor.id" v-text="vendedor.Nombre+vendedor.Apellido"></option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="Servicio">Servicio: </label>
                                            <select class="form-control" v-model="idServicio">
                                                <option value="0" disabled>Seleccione...</option>
                                                <option v-for="servicio in infoServicio" :key="servicio.id" :value="servicio.id" v-text="servicio.Nombre"></option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="FechaE">Fecha Emisión: </label>
                                            <input type="date" class="form-control" v-model="fechaEmision">
                                        </div>
                                         <div class="col-6">
                                            <label for="FechaC">Fecha Cobro: </label>
                                            <input type="date" class="form-control" v-model="fechaCobro">
                                        </div>
                                        <div class="col-6">
                                            <label for="total">Costo del servicio: </label>
                                            <input type="number" class="form-control"  v-model="total">
                                        </div>
                                        <div class="col-6">
                                            <label for="cuota">Cuota: </label>
                                            <input type="number" class="form-control" min="0" v-model="cuota">
                                        </div>
                                        <div class="col-6">
                                            <label for="descuento">Descuento (%): </label>
                                            <input type="number" class="form-control" v-model="descuento">
                                        </div>
                                        <div class="col-6">
                                            <label for="nota">Nota: </label>
                                            <textarea class="form-control" v-model="nota"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label for="beneficiario">Beneficiarios: </label>
                                            <textarea class="form-control" v-model="beneficiario"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" v-if="btnFuncion == 1" @click="registrarContrato()"><i class="fa fa-check"></i> Guardar</button>
                                <button class="btn btn-success" v-if="btnFuncion == 2" @click="actualizarContrato()"><i class="fa fa-check"></i> Actualizar</button>
                                <button class="btn btn-danger" @click="cerrarModal()"><i class="fa fa-remove"></i> Cerrar</button>
                            </div>    
                        </div>
                    </div>
                </div>
                <!-- Fin del modal -->
                <!-- buscador -->
                <div class="buscador d-flex ml-auto hidden-md-down">
                    <label for="" class="etiqueta">Buscar por: </label>
                    <select name="filtro" id="" class="option-search" v-model="criterio">
                        <option value="Nombre">Contrato</option>
                        <!-- <option value="descripcion">Descripción</option> -->
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
                                <option value="Nombre">Contrato</option>
                                <!-- <option value="descripcion">Descripción</option> -->
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
                                    <th>Estados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="contrato in Contratos" :key="contrato.id">
                                    <td>
                                        <button class="boton boton-edit" @click="abrirModal('contrato','actualizar', contrato)"><i class="fa fa-pencil"></i></button>
                                        <template v-if="contrato.Estado == 'Activo'">
                                            <button class="boton boton-eliminar" @click="desactivarContrato(contrato.id)"><i class="fa fa-trash"></i></button>
                                        </template>
                                        <template v-else>
                                            <button class="boton boton-activar" @click="activarContrato(contrato.id)"><i class="fa fa-check-circle"></i></button>
                                        </template>
                                    </td>
                                    <td v-text="contrato.Contrato"></td>
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
                    <div class="row">
                        <div class="col-12 bordered">

                            <h1>hola</h1>
                            <button @click="mostrarTabla()" class="btn btn-danger"> Cerrar</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data(){
            return {
                idContrato: 0,
                contrato: '',
                idCliente: '',
                idVendedor: '',
                idServicio: '',
                total: 0,
                frecuenciaPago : '',
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
                criterio: 'Contrato',
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
                var url= '/empleado/seleccionarEmpleado';
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.infoVendedor = respuesta.empleados;
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
            mostrarTabla(){
                this.mostrar = 1;
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
                        this.descuento = 0;
                        this.beneficiario = '';
                        this.nota = '';
                        this.cuota = 0;
                        break;
                    }
                    case 'actualizar':
                    {
                        this.modal = 1;
                        this.tituloModal = 'Actualizar Contrato';
                        this.btnFuncion = 2;
                        this.idContrato = data['id'];
                        this.contrato = data['Contrato'],
                        this.idCliente = data['idCliente'];
                        this.idVendedor = data['idVendedor'];
                        this.idServicio = data['idServicio'];
                        this.total = data['Total'];
                        this.frecuenciaPago = data['Frecuencia_Pago'];
                        this.fechaEmision = data['Fecha_Emision'];
                        this.fechaCobro = '';
                        this.descuento = data['Descuento'];
                        this.beneficiario = data['Beneficiario'];
                        this.nota = data['Notas'];
                        this.cuota = data['Couta'];
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
                        // 'Frecuencia_Pago': this.frecuenciaPago,
                        'Descuento' : this.descuento,
                        'Beneficiarios' : this.beneficiario,
                        'Nota' : this.nota,
                        'Cuota' : this.cuota
                        }).then(function(response) {
                        me.cerrarModal();
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
                        'Descuento' : this.descuento,
                        'Beneficiario' : this.beneficiario,
                        'Nota' : this.nota,
                        'Cuota' : this.cuota
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarContrato(1,'','Contrato');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            validarFrmContrato(){
                this.errorContrato=0;
                this.msjErrores= [];

                if(this.contrato == ''){
                    this.msjErrores.push("* El campo contrato no puede estar vacío");
                }else if(this.idServicio == ''){
                    this.msjErrores.push("* Debe de seleccionar una opción en servicio");
                }else if(this.idCliente == ''){
                    this.msjErrores.push("* Debe de seleccionar una opción en cliente");
                }else if(this.idVendedor == ''){
                    this.msjErrores.push("* Debe de seleccionar una opción en vendedor");
                }else if(this.total < 0){
                    this.msjErrores.push("* El campo total no puede ser negativo");
                }else if(this.descuento < 0){
                    this.msjErrores.push("* El campo descuento no puede ser negativo");
                }else if(this.cuota < 0){
                    this.msjErrores.push("* El campo cuota no puede ser negativo");
                }else if(this.fechaEmision == ''){
                    this.msjErrores.push("* El campo fecha de emisión no puede estar vacío");
                }else if(this.fechaCobro == ''){
                    this.msjErrores.push("* El campo fecha de cobro no puede estar vacío");
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
                    text: 'Deseas desactivar este Contrato',
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
                            axios.put('/contrato/desactivar', {'id' : id}).then(function(response) {
                                me.mostrarContrato(1,'','Contrato');
                                swal(
                                    'Desactivado',
                                    'El registro fue desactivado correctamente',
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
            abrirModal(modelo, accion, data=[]){
                switch (modelo) {
                    case "contrato":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
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
                                this.descuento = 0;
                                this.beneficiario = '';
                                this.nota = '';
                                this.cuota = 0;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Contrato';
                                this.btnFuncion = 2;
                                this.idContrato = data['id'];
                                this.contrato = data['Contrato'],
                                this.idCliente = data['idCliente'];
                                this.idVendedor = data['idVendedor'];
                                this.idServicio = data['idServicio'];
                                this.total = data['Total'];
                                this.frecuenciaPago = data['Frecuencia_Pago'];
                                this.fechaEmision = data['Fecha_Emision'];
                                this.fechaCobro = '';
                                this.descuento = data['Descuento'];
                                this.beneficiario = data['Beneficiario'];
                                this.nota = data['Notas'];
                                this.cuota = data['Couta'];
                                break;
                            }
                        }
                    }
                }
                this.mostrarVendedor();
                this.mostrarCliente();
                this.mostrarServicio();
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.contrato = '',
                this.idCliente = '';
                this.idVendedor = '';
                this.idServicio = '';
                this.total = 0;
                this.frecuenciaPago = '';
                this.fechaEmision = '';
                this.fechaCobro = '';
                this.descuento = 0;
                this.beneficiario = '';
                this.nota = '';
                this.cuota = 0;
                this.msjErrores = [];
                this.errorContrato = 0;
            },         
        },
        mounted() {
            this.mostrarContrato(1,this.buscar,this.criterio);
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
