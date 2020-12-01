<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
              <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Recibos</h5>
                <!-- Boton nuevo -->
                <button class="btn-new"  @click="mostrarFrm('factura','registrar')" v-if="$can('factura.store')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
                <!-- buscador -->
                <div class="buscador d-flex ml-auto hidden-md-down">
                    <label for="" class="etiqueta">Buscar por: </label>
                    <select name="filtro" id="" class="option-search" v-model="criterio">
                        <option value="id">Recibo</option>
                        <!-- <option value="descripcion">Descripción</option> -->
                    </select>
                    <input type="text" v-model="buscar" @keyup="mostrarFactura(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
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
                            <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="mostrarFactura(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                        </div>
                        <!-- fin del buscador segundo -->
                        <!-- TABLA -->
                        <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                            <thead class="enc-tabla">
                                <tr>
                                    <th>Opciones</th>
                                    <th>NumRecibo</th>
                                    <th>Documento</th>
                                    <th>Monto C$</th>
                                    <th>Fecha</th>
                                    <th>Estados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="factura in Facturas" :key="factura.id" :style="factura.Estado=='Activo'?'':'color:red'">
                                    <td>
                                        <!--<button class="boton boton-edit" @click="abrirModal('factura','actualizar', Factura)"><i class="fa fa-pencil"></i></button>-->
                                        <template v-if="factura.Estado == 'Activo'">
                                            <button class="boton boton-eliminar" @click="desactivarFactura(factura.id)" v-if="$can('factura.cancel')"><i class="fa fa-trash"></i></button>
                                            <button class="boton boton-edit" @click="ImprimirRecibo(factura.id, factura.Documento)"><i class="fa fa-print"></i></button>
                                        </template>
                                        <button class="boton boton-mirar" @click="mostrardatos(factura.id, factura.Documento)"><i class="fa fa-eye"></i></button>
                                    </td>
                                    <td v-text="factura.id"></td>
                                    <td v-text="factura.TipoDocumento"></td>
                                    <td v-text="factura.Monto"></td>
                                    <td v-text="factura.Fecha_Pago"></td>
                                    <td v-text="factura.Estado"></td>
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
                <template v-else-if="mostrar == 2">
                    <div class="row m-1">
                        <!-- tasa de cambio -->
                        <div class="col-md-2 form-group">
                            <label for="" class="form-control-label">Cambio ($): </label>
                            <input type="text" class="form-control" readonly v-model="dolar">
                        </div>
                        <!--Seleccionar documento-->
                        <div class="col-md-4 form-group">
                            <label for="" class="form-control-label">Tipo Factura: </label>
                            <select name="" id="" v-model="tipoDocumento" class="form-control">
                                <option value="Contrato">Contrato</option>
                                <option value="Financiamiento">Financiamiento</option>
                            </select>
                        </div>
                        <!-- # de documento -->
                        <div class="col-md-4 form-group">
                            <label for="Cliente" class="form-control-label" v-if="tipoDocumento == 'Contrato'">No. Contrato: </label>
                            <label for="Cliente" class="form-control-label" v-else>No. Financiamiento: </label>
                            <input type="text" name="" id="" class="form-control" v-model="numeroDoc">
                        </div>
                        <!-- Boton Buscar -->
                        <div class="col-md-2 form-group mt-auto d-flex align-self-center">
                            <button class="btn btn-success" @click="buscarInformacion(tipoDocumento, numeroDoc)">Buscar</button>
                        </div>
                        <!-- <div v-show="errorFactura" class="form-group col-12 msjerror">
                            <div class="col-12 text-center texterror" v-for="error in msjVal" :key="error" v-text="error"></div>
                        </div> -->

                        <!-- Cliente -->
                        <div class="col-md-6 form-group">
                            <label for="" class="form-control-label">Cliente: </label>
                            <input type="text" class="form-control" readonly v-model="cliente">
                        </div>
                        
                        <!-- Cuota -->
                        <div class="col-md-3 form-group">
                            <label for="" class="form-control-label">Cuota (C$): </label>
                            <input type="text" class="form-control" readonly v-model="cuota">
                        </div>
                        <!-- saldo restant -->
                        <div class="col-md-3 form-group">
                            <label for="" class="form-control-label">Saldo Restante(C$): </label>
                            <input type="text" class="form-control" readonly v-model="saldor">
                        </div>
                        <!-- Monto  -->
                        <div class="col-md-6 form-group">
                            <label for="" class="form-control-label">Abono (C$): </label>
                            <input type="number" class="form-control" min="0" v-model="monto">
                        </div>
                        <div v-show="errorFactura" class="form-group msjerror">
                            <div class="col-12 text-center texterror" v-for="error in msjErrores" :key="error" v-text="error"></div>
                        </div>
                        <div class="mx-2 my-1 col-12">
                            <button class="btn btn-success" @click="registrarFactura()"><i class="fa fa-check"></i> Guardar</button>
                            <button @click="mostrarTabla()" class="btn btn-danger"><i class="fa fa-close"></i> Cerrar</button>
                        </div>
                    </div>
                </template>
                <template v-if="mostrar == 3">
                    <div class="row m-1">
                        <div style="border-top: 1px solid gray; border-bottom: 1px solid gray;" class="col-md-12">
                            <label class="text-center d-block">Datos del Cliente</label>
                        </div>
                        <div class="col-md-6">
                            <p><b>Cliente:</b> {{cliente}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Teléfono:</b> {{telefono}}</p>
                        </div>
                        <div class="col-md-12">
                            <p><b>Dirección:</b> {{direccion}}</p>
                        </div>
                        <div style="border-top: 1px solid gray; border-bottom: 1px solid gray;" class="col-md-12">
                            <label class="text-center d-block">Detalle del Recibo</label>
                        </div>
                        <div class="col-md-6">
                            <p><b>Num Recibo:</b> {{idFactura}}</p>
                        </div>
                        <div class="col-md-6">
                            <p :style="estado == 'Activo'?'color: green; font-weight: bold' : 'color: red; font-weight: bold'"><b>Estado:</b> {{estado}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Num Contrato:</b> {{numeroDoc}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Servicio:</b> {{servicio}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Fecha Emisión:</b> {{fecha}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Total Servicio:</b> C${{total}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Monto:</b> C${{monto}}</p>
                        </div>
                        <div class="col-md-6">
                            <p><b>Saldo Restante:</b> C${{saldor}}</p>
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
    export default {
        data(){
            return {
                idFactura: 0,
                idDocumento: 0,
                idTasa: 0,
                idCliente: 0,
                dolar: 0,
                tipoDocumento: 'Contrato',
                cuota: 0,
                saldor: 0,
                monto: 0,
                numeroDoc: '',
                cliente: '',
                Facturas: [],
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
                criterio: 'id',
                buscar: '',
                estado: '',
                fecha: '',
                servicio: '',
                direccion: '',
                telefono: '',
                total: 0,
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
            mostrarFactura(pagina,buscar,criterio){
                let me = this;
                var url= '/factura?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.Facturas = respuesta.facturas.data;
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
                    me.dolar = "C$ " + me.infoTasa.Monto;
                    me.idTasa = me.infoTasa.id;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarFactura(){
                if(this.validarFrmFactura()){
                    return;
                }
                else{
                    let me = this;
                    axios.post('/factura/registrar', {
                        'idDolar' : this.idTasa, 
                        'idDocumento': this.idDocumento,
                        'TipoDocumento': this.tipoDocumento,
                        'Monto': this.monto,
                        'NumContrato' : this.numeroDoc,
                        'Dolar' : me.infoTasa.Monto,
                        'Saldo' : me.saldor,
                        'idCliente': me.idCliente
                        }).then(function(response) {
                            me.mostrarTabla();
                            me.mostrarFactura(1,'','idDocumento');
                            me.notificacion();
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            notificacion(){
                toastr.success('Recibo Registrato',{
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
            ImprimirRecibo(id, doc){
                window.open('http://127.0.0.1:8000/print/recibo/'+id+'/'+doc);
            },
            validarFrmFactura(){
                this.errorFactura=0;
                this.msjErrores= [];

                if(this.numeroDoc == ""){
                    this.msjErrores.push("* El numero del registro no puede estas vacío");
                }else if(this.monto == 0){
                    this.msjErrores.push("* El abono no puede ser 0");
                }else if(parseFloat(this.monto) > parseFloat(this.saldor) ){
                    this.msjErrores.push("* El abono no puede superar al saldo restante");
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
                confirmButtonText: 'Anular Recibo',
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
                    axios.put('/factura/anular', {
                        'id' : this.id,
                        'Motivo' : result.value
                        })
                    .then(function (response) {
                        Swal.fire(
                        'Anulado',
                        'Se hizo cambio en otros datos',
                        'Existoso'
                        )
                        me.mostrarFactura(1,'','idDocumento');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                    }     
                    
                })
            },
            buscarInformacion(tipodoc,numdoc){
                let me = this;
                var url= '/factura/buscar?&tipoDocumento=' + tipodoc + '&numeroDoc=' + numdoc;
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.informacion = respuesta.informacion;
                    me.cliente = me.informacion.Cliente;
                    me.cuota = parseFloat(me.informacion.Total) / parseFloat(me.informacion.Cuota);
                    me.saldor = me.informacion.subTotal;
                    me.idDocumento = me.informacion.idCxC;
                    me.idCliente = me.idCliente;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });

                // this.errorFactura=0;
                // this.msjVal= [];
                // if(numdoc == ""){
                //     this.msjVal.push("* El campo numero no puede estar vacío");
                //     this.errorFactura = 1;
                // }else if(me.informacion == null){
                //     me.cliente = "";
                //     me.cuota = 0;
                //     me.saldor = 0;
                //     this.msjVal.push("* Información no fue encontrada, verifique el dato de busqueda");
                //     this.errorFactura = 1;
                // } else{
                //     me.cliente = me.informacion.Cliente;
                //     me.cuota = parseFloat( parseFloat(me.informacion.Total) / parseFloat(me.informacion.cuota) );
                //     me.saldor = me.informacion.SaldoR;
                //     this.msjVal = [];
                //     this.errorFactura = 0;
                // }
                //     return this.errorFactura;
            },
            cambiarPagina(pagina,buscar,criterio){
                let me = this;
                me.pagination.current_page = pagina;
                me.mostrarFactura(pagina,buscar,criterio);
            },
            mostrarFrm(modelo,accion,data=[]){
                this.mostrar = 2;
                switch (modelo) {
                    case "factura":
                        switch (accion) {
                            case 'registrar':
                            {
                                break;
                            }
                    }    

                }
                this.mostrarTasaC();
            },
            mostrarTabla(){
                this.mostrar = 1;
                this.cuota = 0;
                this.saldor = 0;
                this.monto = 0;
                this.numeroDoc = '';
                this.cliente = '';
                this.fecha = '';
                this.estado = '';
                this.idFactura = 0;
                this.servicio = '';
                this.cliente = '';
                this.idFactura = 0;
                this.numeroDoc = '';
            },   
            mostrardatos(id,documento){
                let me = this;
                me.mostrar = 3;
                me.idFactura =  id;
                var url= '/factura/informacion?idFactura='+id+'&Doc='+documento;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.fecha = respuesta.informacion[0].FechaEmision;
                    me.servicio = respuesta.informacion[0].Servicio;
                    me.estado = respuesta.informacion[0].Estado;
                    me.cliente = respuesta.informacion[0].cliente;
                    me.monto = respuesta.informacion[0].Monto;
                    me.idFactura = respuesta.informacion[0].id;
                    me.numeroDoc = respuesta.informacion[0].Contrato;
                    me.direccion = respuesta.informacion[0].Direccion;
                    me.telefono = respuesta.informacion[0].Telefono;
                    me.saldor = respuesta.informacion[0].TotalRestante;
                    me.total = respuesta.informacion[0].Total;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }

        },
        mounted() {
            this.mostrarFactura(1,this.buscar,this.criterio);
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
