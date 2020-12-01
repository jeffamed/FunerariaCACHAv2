<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Zonas</h5>
            <!-- Boton nuevo -->
                <button class="btn-new"  @click="abrirModal('zona','registrar')" v-if="$can('zona.store')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
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
                                    <div class="form-group">
                                        <label for="nombre">Nombre: </label>
                                        <input type="text" class="form-control" placeholder="Nombre..." v-model="nombre" required>
                                    </div>
                                    <div class="form-group">
                                         <label for="empleado">Empleado: </label>
                                         <select class="form-control" v-model="idColector" required>
                                            <option value="0" disabled>Seleccione...</option>
                                            <option v-for="empleado in infoEmpleado" :value="empleado.id" :key="empleado.id" v-text="empleado.Nombre+' '+empleado.Apellido"></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                         <label for="municipio">Municipio: </label>
                                         <select class="form-control" v-model="idMunicipio" required>
                                            <option value="0" disabled>Seleccione...</option>
                                            <option v-for="municipio in infoMunicipio" :value="municipio.id" :key="municipio.id" v-text="municipio.Nombre"></option>
                                        </select>
                                    </div>
                                    <div v-show="errorZona" class="form-group msjerror">
                                        <div class="text-center texterror" v-for="error in msjErrores" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" v-if="btnFuncion == 1" @click="registrarZona()"><i class="fa fa-check"></i> Guardar</button>
                                <button class="btn btn-success" v-if="btnFuncion == 2" @click="actualizarZona()"><i class="fa fa-check"></i> Actualizar</button>
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
                        <option value="Nombre">Zona</option>
                        <!-- <option value="descripcion">Descripción</option> -->
                    </select>
                    <input type="text" v-model="buscar" @keyup="mostrarZona(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
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
                            <option value="Nombre">Zona</option>
                            <!-- <option value="descripcion">Descripción</option> -->
                        </select>
                        <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="mostrarZona(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                    </div>
                    <!-- fin del buscador segundo -->
                    <!-- TABLA -->
                    <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                        <thead class="enc-tabla">
                            <tr>
                                <th>Opciones</th>
                                <th>Zonas</th>
                                <th>Empleado</th>
                                <th>Municipio</th>
                                <th>Estados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="zona in Zonas" :key="zona.id" :style="zona.Estado=='Activo'?'':'color:red'">
                                <td>
                                    <button class="boton boton-edit" @click="abrirModal('zona','actualizar', zona)" v-if="$can('zona.update')"><i class="fa fa-pencil"></i></button>
                                    <template v-if="zona.Estado == 'Activo'">
                                        <button class="boton boton-eliminar" @click="desactivarZona(zona.id)" v-if="$can('zona.inactive')"><i class="fa fa-trash"></i></button>
                                    </template>
                                    <template v-else>
                                        <button class="boton boton-activar" @click="activarZona(zona.id)" v-if="$can('zona.active')"><i class="fa fa-check-circle"></i></button>
                                    </template>
                                </td>
                                <td v-text="zona.Nombre"></td>
                                <td v-text="zona.Empleado"></td>
                                <td v-text="zona.Municipio"></td>
                                <td v-text="zona.Estado"></td>
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
                idZona: 0,
                nombre: '',
                idColector: 0,
                idMunicipio: 0,
                infoMunicipio: [],
                Zonas: [],
                infoEmpleado: [],
                modal: 0,
                tituloModal: '',
                btnFuncion: 0,
                errorZona: 0,
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
            mostrarZona(pagina,buscar,criterio){
                let me = this;
                var url= '/zona?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.Zonas = respuesta.zonas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarEmpleado(){
                let me = this;
                var url= '/empleado/seleccionarEmpleado';
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.infoEmpleado = respuesta.empleados;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarMunicipio(){
                let me = this;
                var url= '/municipio/seleccionarMunicipio';
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.infoMunicipio = respuesta.municipios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarZona(){
                if(this.validarFrmZona()){
                    return;
                }
                else{
                    let me = this;
                    axios.post('/zona/registrar', {
                        'Nombre' : this.nombre, 
                        'idColector': this.idColector,
                        'idMunicipio': this.idMunicipio
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarZona(1,'','Nombre');
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            actualizarZona(){
                if(this.validarFrmZona()){
                    return;
                }
                else{
                    let me = this;
                    axios.put('/zona/actualizar', {
                        'id' : this.idZona, 
                        'Nombre' : this.nombre, 
                        'idColector' : this.idColector,
                        'idMunicipio' : this.idMunicipio
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarZona(1,'','Nombre');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            validarFrmZona(){
                this.errorZona=0;
                this.msjErrores= [];

                if(this.nombre == '' && this.idColector == 0){
                    this.msjErrores.push("* El campo nombre no puede estar vacío");
                    this.msjErrores.push("* Debe seleccionar una opción en el empleado");
                }else if(this.nombre == ''){
                    this.msjErrores.push("* El campo nombre no puede estar vacío");
                } else if(this.idColector == 0){
                    this.msjErrores.push("* Debe seleccionar una opción en el empleado");
                }

                if(this.msjErrores.length) 
                {
                    this.errorZona= 1;
                }
                return this.errorZona;
            },
            activarZona(id){
                swal({
                    title: '¿Estas seguro?',
                    text: 'Deseas activar este Zona',
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
                            axios.put('/zona/activar', {'id' : id}).then(function(response) {
                                me.mostrarZona(1,'','Nombre');
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
            desactivarZona(id){
                swal({
                    title: '¿Estas seguro?',
                    text: 'Deseas desactivar este Zona',
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
                            axios.put('/zona/desactivar', {'id' : id}).then(function(response) {
                                me.mostrarZona(1,'','Nombre');
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
                me.mostrarZona(pagina,buscar,criterio);
            },
            abrirModal(modelo, accion, data=[]){
                switch (modelo) {
                    case "zona":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Zona';
                                this.nombre = '';
                                this.idColector = 0;
                                this.idMunicipio = 0;
                                this.btnFuncion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Zona';
                                this.btnFuncion = 2;
                                this.idZona = data['id'];
                                this.nombre = data['Nombre'];
                                this.idColector = data['idEmpleado'];
                                this.idMunicipio = data['idMunicipio'];
                                break;
                            }
                        }
                    }
                }

                this.mostrarEmpleado();
                this.mostrarMunicipio();
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
                this.idMunicipio = 0;
                this.msjErrores = [];
                this.errorZona = 0;
                this.idColector = 0;
            },         
        },
        mounted() {
            this.mostrarZona(1,this.buscar,this.criterio);
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
