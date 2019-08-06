<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Facturas</h5>
            <!-- Boton nuevo -->
                <button class="btn-new"  @click="mostrarFrm('factura','registrar')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
                <!-- buscador -->
                <div class="buscador d-flex ml-auto hidden-md-down">
                    <label for="" class="etiqueta">Buscar por: </label>
                    <select name="filtro" id="" class="option-search" v-model="criterio">
                        <option value="Nombre">Factura</option>
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
                                <option value="Nombre">Factura</option>
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
                                    <th>Facturas</th>
                                    <th>Departamento</th>
                                    <th>Estados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="factura in Facturas" :key="factura.id" :style="factura.Estado=='Activo'?'':'color:red'">
                                    <td>
                                        <button class="boton boton-edit" @click="abrirModal('factura','actualizar', Factura)"><i class="fa fa-pencil"></i></button>
                                        <template v-if="factura.Estado == 'Activo'">
                                            <button class="boton boton-eliminar" @click="desactivarFactura(Factura.id)"><i class="fa fa-trash"></i></button>
                                        </template>
                                        <template v-else>
                                            <button class="boton boton-activar" @click="activarFactura(Factura.id)"><i class="fa fa-check-circle"></i></button>
                                        </template>
                                    </td>
                                    <td v-text="factura.Nombre"></td>
                                    <td v-text="factura.Departamento"></td>
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
                <template v-else>
                    <div class="row m-1">
                         <!--Seleccionar documento-->
                        <div class="col-md-6 form-group">
                            <label for="" class="form-control-label">Tipo Factura: </label>
                            <select name="" id="" v-model="tipoDocumento" class="form-control">
                                <option value="Contrato">Contrato</option>
                                <option value="Financiamiento">Financiamiento</option>
                            </select>
                        </div>
                        <!-- # de documento -->
                        <div class="col-md-6 form-group">
                            <label for="Cliente" class="form-control-label" v-if="tipoDocumento == 'Contrato'">No. Contrato: </label>
                            <label for="Cliente" class="form-control-label" v-else>No. Financiamiento: </label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                        <!-- Cliente -->
                        <div class="col-md-6 form-group">
                            <label for="" class="form-control-label">Cliente: </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <!-- tasa de cambio -->
                        <div class="col-md-6 form-group">
                            <label for="" class="form-control-label">Cambio ($): </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <!-- Cuota -->
                        <div class="col-md-6 form-group">
                            <label for="" class="form-control-label">Cuota (C$): </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <!-- Monto  -->
                        <div class="col-md-6 form-group">
                            <label for="" class="form-control-label">Abono (C$): </label>
                            <input type="number" class="form-control" min="0">
                        </div>
                        <div class="mx-2 my-1 col-12">
                            <button class="btn btn-success" @click="registrarContrato()"><i class="fa fa-check"></i> Guardar</button>
                            <button @click="mostrarTabla()" class="btn btn-danger"><i class="fa fa-close"></i> Cerrar</button>
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
                tipoDocumento: 'Contrato',
                monto: '',
                Facturas: [],
                errorFactura: 0,
                mostrar: 1,
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
                criterio: 'Nombre',
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
            mostrarDepartamento(){
                let me = this;
                var url= '/departamento/seleccionarDepartamento';
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.infoDepartamento = respuesta.departamentos;
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
                    axios.post('/Factura/registrar', {
                        'Nombre' : this.nombre, 
                        'idDocumento': this.idDocumento
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarFactura(1,'','Nombre');
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            validarFrmFactura(){
                this.errorFactura=0;
                this.msjErrores= [];

                if(this.nombre == '' && this.idDocumento == 0){
                    this.msjErrores.push("* El campo nombre no puede estar vacío");
                    this.msjErrores.push("* Debe seleccionar una opción en el departamento");
                }else if(this.nombre == ''){
                    this.msjErrores.push("* El campo nombre no puede estar vacío");
                } else if(this.idDocumento == 0){
                    this.msjErrores.push("* Debe seleccionar una opción en el departamento");
                }

                if(this.msjErrores.length) 
                {
                    this.errorFactura= 1;
                }
                return this.errorFactura;
            },
            desactivarFactura(id){
                swal({
                    title: '¿Estas seguro?',
                    text: 'Deseas desactivar este Factura',
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
                            axios.put('/Factura/desactivar', {'id' : id}).then(function(response) {
                                me.mostrarFactura(1,'','Nombre');
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
                this.mostrarContrato();
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
                this.beneficiario = '';
                this.cuota = 0;
                this.msjErrores = [];
                this.errorFinanciamiento = 0;
            },        
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
