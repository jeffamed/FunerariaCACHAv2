<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Empleados</h5>
            <!-- Boton nuevo -->
                <button class="btn-new"  @click="abrirModal('empleado','registrar')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
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
                                    <div class="form-group form-inline">
                                        <label for="nombre">Nombres: </label>
                                        <input type="text" class="form-control" placeholder="Nombre..." v-model="nombre">
                                        <label for="apellido">Apellidos: </label>
                                        <input type="text" class="form-control" placeholder="Apellidos..." v-model="apellido">
                                    </div>
                                    <div class="form-group form-inline">
                                        <label for="nombre">Nombres: </label>
                                        <input type="text" class="form-control" placeholder="Nombre..." v-model="nombre">
                                        <label for="nombre">Apellidos: </label>
                                        <input type="text" class="form-control" placeholder="Apellidos..." v-model="nombre">
                                    </div>
                                    <div v-show="errorEmpleado" class="form-group msjerror">
                                        <div class="text-center texterror" v-for="error in msjErrores" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" v-if="btnFuncion == 1" @click="registrarEmpleado()"><i class="fa fa-check"></i> Guardar</button>
                                <button class="btn btn-success" v-if="btnFuncion == 2" @click="actualizarEmpleado()"><i class="fa fa-check"></i> Actualizar</button>
                                <button class="btn btn-danger" @click="cerrarModal()"><i class="fa fa-remove"></i> Cerrar</button>
                            </div>    
                        </div>
                    </div>
                </div>
                <!-- Fin del modal -->
                <!-- buscador -->
                <div class="buscador d-flex ml-auto hidden-md-down">
                    <label for="" class="etiqueta">Buscar por: </label>
                    <select name="filtro" class="option-search" v-model="criterio">
                        <option value="Nombre">Nombre</option>
                        <option value="Apellido">Apellido</option>
                    </select>
                    <input type="text" v-model="buscar" @keyup="mostrarEmpleado(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
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
                            <option value="Nombre">Nombre</option>
                            <option value="Apellido">Apellido</option>
                        </select>
                        <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="mostrarEmpleado(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                    </div>
                    <!-- fin del buscador segundo -->
                    <!-- TABLA -->
                    <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                        <thead class="enc-tabla">
                            <tr>
                                <th>Opciones</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Telefóno</th>
                                <th>Dirección</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="empleado in Empleados" :key="empleado.id">
                                <td>
                                    <button class="boton boton-edit" @click="abrirModal('empleado','actualizar', empleado)"><i class="fa fa-pencil"></i></button>
                                    <template v-if="Empleado.Estado == 'Activo'">
                                        <button class="boton boton-eliminar" @click="desactivarEmpleado(empleado.id)"><i class="fa fa-trash"></i></button>
                                    </template>
                                    <template v-else>
                                        <button class="boton boton-activar" @click="activarEmpleado(empleado.id)"><i class="fa fa-check-circle"></i></button>
                                    </template>
                                </td>
                                <td v-text="empleado.Nombre"></td>
                                <td v-text="empleado.Apellido"></td>
                                <td v-text="empleado.Telefono"></td>
                                <td v-text="empleado.Direccion"></td>
                                <td v-text="empleado.Estado"></td>
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
                idEmpleado: 0,
                nombre: '',
                apellido: '',
                telefono: '',
                cedula: '',
                direccion: '',
                Empleados: [],
                modal: 0,
                tituloModal: '',
                btnFuncion: 0,
                errorEmpleado: 0,
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
            mostrarEmpleado(pagina,buscar,criterio){
                let me = this;
                var url= '/empleado?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.Empleados = respuesta.Empleados.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(pagina,buscar,criterio){
                let me = this;
                me.pagination.current_page = pagina;
                me.mostrarEmpleado(pagina,buscar,criterio);
            },
            registrarEmpleado(){
                if(this.validarFrmEmpleado()){
                    return;
                }
                else{
                    let me = this;
                    axios.post('/empleado/registrar', {
                        'Nombre' : this.nombre,
                        'Apellido' : this.apellido,
                        'Telefono' : this.telefono,
                        'Cedula' : this.cedula,
                        'Direccion' : this.direccion
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarEmpleado(1,'','Nombre');
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            actualizarEmpleado(){
                if(this.validarFrmEmpleado()){
                    return;
                }
                else{
                    let me = this;
                    axios.put('/empleado/actualizar', {
                        'Nombre' : this.nombre, 
                        'Apellido' : this.apellido,
                        'Telefono' : this.telefono,
                        'Cedula' : this.cedula,
                        'Direccion' : this.direccion,
                        'id' : this.idEmpleado
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarEmpleado(1,'','Nombre');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            validarFrmEmpleado(){
                this.errorEmpleado=0;
                this.msjErrores= [];

                if(this.nombre == ''){
                    this.msjErrores.push("* El campo nombre no puede estar vacío");
                }else if(this.apellido == ''){
                    this.msjErrores.push("* El campo apellido no puede estar vacío");
                }else if(this.telefono == ''){
                    this.msjErrores.push("* El campo telefono no puede estar vacío o el formato no es valido");
                }else if(this.cedulo == ''){
                    this.msjErrores.push("* El campo cedulo no puede estar vacío o el formato no es valido");
                }else if(this.direccion == ''){
                    this.msjErrores.push("* El campo direccion no puede estar vacío");
                }

                if(this.msjErrores.length) 
                {
                    this.errorEmpleado= 1;
                }
                return this.errorEmpleado;
            },
            activarEmpleado(id){
                swal({
                    title: '¿Estas seguro?',
                    text: 'Deseas activar este empleado',
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
                            axios.put('/empleado/activar', {'id' : id}).then(function(response) {
                                me.mostrarEmpleado(1,'','Nombre');
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
            desactivarEmpleado(id){
                swal({
                    title: '¿Estas seguro?',
                    text: 'Deseas desactivar este empleado',
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
                            axios.put('/empleado/desactivar', {'id' : id}).then(function(response) {
                                me.mostrarEmpleado(1,'','Nombre');
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
                    case "empleado":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Empleado';
                                this.nombre = '';
                                this.apellido= '';
                                this.telefono= '';
                                this.cedula= '';
                                this.direccion= '';
                                this.btnFuncion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Empleado';
                                this.btnFuncion = 2;
                                this.idEmpleado = data['id'];
                                this.nombre = data['Nombre'];
                                this.apellido= data['Apellido'];
                                this.telefono= data['Telefono'];
                                this.cedula= data['Cedula'];
                                this.direccion= data['Direccion'];
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
                this.apellido= '';
                this.telefono= '';
                this.cedula= '';
                this.direccion= '';
                this.msjErrores = [];
                this.errorEmpleado = 0;
            },         
        },
        mounted() {
            this.mostrarEmpleado(1,this.buscar,this.criterio);
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

