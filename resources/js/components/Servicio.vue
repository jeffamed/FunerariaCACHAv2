<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Servicios</h5>
            <!-- Boton nuevo -->
                <button class="btn-new"  @click="abrirModal('servicio','registrar')" v-if="$can('servicio.store')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
                <!-- Abrir Modal-->
                <div class="modal fade" id="btn-new" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="btn-new" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-white" v-text="tituloModal"></h5>
                                <button class="close" aria-label="Cerrar" @click="cerrarModal()">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div v-if="btnFuncion!=3">
                                        <div class="form-group">
                                            <label for="nombre">Nombre: </label>
                                            <input type="text" class="form-control" placeholder="Nombre..." v-model="nombre">
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre">Proyecto: </label>
                                            <select class="form-control" v-model="idProyecto" required>
                                            <option value="0" disabled>Seleccione...</option>
                                            <option v-for="proyecto in infoProyecto" :value="proyecto.id" :key="proyecto.id" v-text="proyecto.Nombre"></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="Monto">Costo (C$): </label>
                                            <input type="number" min="0" v-model="monto" class="form-control" placeholder="00,00">
                                        </div>
                                        <div class="form-group">
                                            <label for="descripcion">Descripción: </label>
                                            <textarea class="form-control" v-model="descripcion"></textarea>
                                        </div>
                                        <div v-show="errorServicio" class="form-group msjerror">
                                            <div class="text-center texterror" v-for="error in msjErrores" :key="error" v-text="error"></div>
                                        </div>
                                    </div>
                                    <div v-else>
                                         <div class="d-flex">
                                            <b><label for="">Nombre: </label></b>
                                            <p v-text="nombre"></p>
                                        </div>
                                        <div class="d-flex">
                                            <b><label for="">Proyecto: </label></b>
                                            <p v-text="nombreProyecto"></p>
                                        </div>
                                        <div class="d-flex">
                                            <b><label for="">Costo: </label></b>
                                            <p v-text="monto"></p>
                                        </div>
                                        <div class="d-flex">
                                            <b><label for="">Descripción: </label></b>
                                            <p v-text="descripcion"></p>
                                        </div>
                                        <div class="d-flex">
                                            <b><label for="">Estado: </label></b>
                                            <p v-text="estado"></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" v-if="btnFuncion == 1" @click="registrarServicio()"><i class="fa fa-check"></i> Guardar</button>
                                <button class="btn btn-success" v-if="btnFuncion == 2" @click="actualizarServicio()"><i class="fa fa-check"></i> Actualizar</button>
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
                        <option value="Nombre">Servicio</option>
                        <!-- <option value="descripcion">Descripción</option> -->
                    </select>
                    <input type="text" v-model="buscar" @keyup="mostrarServicio(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
                    <div class="icon-buscar">
                        <i class="fa fa-search hidden-md-down"></i>
                    </div> 
                </div>
                <!-- Fin del buscador -->
            </div>
            <!-- CUERPO -->
            <div class="contenido__cuerpo" id="cuerpo-contenido">
                <div class="table-responsive tabla-contenido">
                    <!-- Buscador segundo-->
                    <div class="form-inline mt-2 mb-2">
                        <label for="buscar" class="hidden-lg-up ml-1">Buscar por: </label>
                        <select id="select-opciones" class="custom-select hidden-lg-up mb-1 mr-1 w-25" v-model="criterio">
                            <option value="Nombre">Servicio</option>
                            <!-- <option value="descripcion">Descripción</option> -->
                        </select>
                        <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="mostrarServicio(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                    </div>
                    <!-- fin del buscador segundo -->
                    <!-- TABLA -->
                    <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                        <thead class="enc-tabla">
                            <tr>
                                <th>Opciones</th>
                                <th>Servicios</th>
                                <th>Monto C$</th>
                                <th>Proyecto</th>
                                <th>Estados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="servicio in Servicios" :key="servicio.id" :style="servicio.Estado=='Activo'?'':'color:red'">
                                <td>
                                    <button class="boton boton-edit" @click="abrirModal('servicio','actualizar', servicio)" v-if="$can('servicio.update')"><i class="fa fa-pencil"></i></button>
                                    <template v-if="servicio.Estado == 'Activo'">
                                        <button class="boton boton-eliminar" @click="desactivarServicio(servicio.id)" v-if="$can('servicio.inactive')"><i class="fa fa-trash"></i></button>
                                    </template>
                                    <template v-else>
                                        <button class="boton boton-activar" @click="activarServicio(servicio.id)" v-if="$can('servicio.active')"><i class="fa fa-check-circle"></i></button>
                                    </template>
                                    <button class="boton boton-mirar" @click="abrirModal('servicio','mostrar', servicio)"><i class="fa fa-eye"></i></button>
                                </td>
                                <td v-text="servicio.Nombre"></td>
                                <td v-text="servicio.Monto"></td>
                                <td v-text="servicio.Proyecto"></td>
                                <td v-text="servicio.Estado"></td>
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
    </section>
</template>

<script>
    export default {
        data(){
            return {
                idServicio: 0,
                nombre: '',
                monto: 0,
                descripcion: '',
                idProyecto: 0,
                nombreProyecto: '',
                estado: '',
                Servicios: [],
                infoProyecto: [],
                modal: 0,
                tituloModal: '',
                btnFuncion: 0,
                errorServicio: 0,
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
            mostrarServicio(pagina,buscar,criterio){
                let me = this;
                var url= '/servicio?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.Servicios = respuesta.servicios.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarProyecto(){
                let me = this;
                var url= '/proyecto/seleccionarProyecto';
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.infoProyecto = respuesta.proyectos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarServicio(){
                if(this.validarFrmServicio()){
                    return;
                }
                else{
                    let me = this;
                    axios.post('/servicio/registrar', {
                        'Nombre' : this.nombre, 
                        'idProyecto': this.idProyecto,
                        'Monto': this.monto,
                        'Descripcion': this.descripcion
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarServicio(1,'','Nombre');
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            actualizarServicio(){
                if(this.validarFrmServicio()){
                    return;
                }
                else{
                    let me = this;
                    axios.put('/servicio/actualizar', {
                        'Nombre' : this.nombre, 
                        'id' : this.idServicio, 
                        'idProyecto' : this.idProyecto,
                        'Monto': this.monto,
                        'Descripcion': this.descripcion
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarServicio(1,'','Nombre');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            validarFrmServicio(){
                this.errorServicio=0;
                this.msjErrores= [];

                if(this.nombre == ''){
                    this.msjErrores.push("* El campo nombre no puede estar vacío");
                } else if(this.idProyecto == 0){
                    this.msjErrores.push("* Debe seleccionar una opción en el proyecto");
                }else if(this.descripcion == ''){
                    this.msjErrores.push("* Debe de agregar informacion en el campo descripción");
                }else if(this.monto < 0){
                    this.msjErrores.push("* El costo del servicio no puede ser negativo")
                }
                    // this.monto.replace(/./i,",");
                    
                if(this.msjErrores.length) 
                {
                    this.errorServicio= 1;
                }
                return this.errorServicio;
            },
            activarServicio(id){
                swal({
                    title: '¿Estas seguro?',
                    text: 'Deseas activar este Servicio',
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
                            axios.put('/servicio/activar', {'id' : id}).then(function(response) {
                                me.mostrarServicio(1,'','Nombre');
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
            desactivarServicio(id){
                swal({
                    title: '¿Estas seguro?',
                    text: 'Deseas desactivar este Servicio',
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
                            axios.put('/servicio/desactivar', {'id' : id}).then(function(response) {
                                me.mostrarServicio(1,'','Nombre');
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
                me.mostrarServicio(pagina,buscar,criterio);
            },
            abrirModal(modelo, accion, data=[]){
                switch (modelo) {
                    case "servicio":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Servicio';
                                this.nombre = '';
                                this.idProyecto = 0;
                                this.btnFuncion = 1;
                                this.monto = 0;
                                this.descripcion = '';
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Servicio';
                                this.btnFuncion = 2;
                                this.idServicio = data['id'];
                                this.nombre = data['Nombre'];
                                this.idProyecto = data['idProyecto'];
                                this.monto = data['Monto'];
                                this.descripcion = data['Descripcion'];
                                break;
                            }
                            case 'mostrar':
                            { 
                                this.modal = 1;
                                this.tituloModal = 'Información del Servicio';
                                this.btnFuncion = 3;
                                this.nombre = data['Nombre'];
                                this.nombreProyecto = data['Proyecto'];
                                this.monto = data['Monto'];
                                this.descripcion = data['Descripcion'];
                                this.estado = data['Estado'];
                                break;
                            }
                        }
                    }
                }

                this.mostrarProyecto();
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
                this.msjErrores = [];
                this.errorServicio = 0;
                this.idProyecto = 0;
                this.monto = 0;
                this.descripcion = '';
            },         
        },
        mounted() {
            this.mostrarServicio(1,this.buscar,this.criterio);
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
