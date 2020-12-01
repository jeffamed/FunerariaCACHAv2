<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Usuarios</h5>
            <!-- Boton nuevo -->
                <button class="btn-new"  @click="abrirModal('usuario','registrar')" v-if="$can('acceso.store')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
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
                                         <label for="usuario">Empleado: </label>
                                         <select class="form-control" v-model="idEmpleado" required>
                                            <option value="0" disabled>Seleccione...</option>
                                            <option v-for="empleado in infoEmpleado" :value="empleado.id" :key="empleado.id" v-text="empleado.Nombre"></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="usuario">Usuario: </label>
                                        <input type="text" class="form-control" placeholder="usuario..." v-model="usuario">
                                    </div>
                                    <div class="form-group">
                                        <label for="Contraseña">Contraseña: </label>
                                        <input type="password" class="form-control" placeholder="*******" v-model="password">
                                    </div>
                                    <div class="form-group">
                                         <label for="rol">Rol: </label>
                                         <select class="form-control" v-model="rol" required>
                                            <option value="" disabled>Seleccione...</option>
                                            <option v-for="rol in listaRoles" :value="rol.id" :key="rol.id" v-text="rol.name"></option>
                                        </select>
                                    </div>
                                    <div v-show="errorUsuario" class="form-group msjerror">
                                        <div class="text-center texterror" v-for="error in msjErrores" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" v-if="btnFuncion == 1" @click="registrarUsuario()"><i class="fa fa-check"></i> Guardar</button>
                                <button class="btn btn-success" v-if="btnFuncion == 2" @click="actualizarUsuario()"><i class="fa fa-check"></i> Actualizar</button>
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
                        <option value="Usuario">Usuario</option>
                        <!-- <option value="descripcion">Descripción</option> -->
                    </select>
                    <input type="text" v-model="buscar" @keyup="mostrarUsuario(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
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
                            <option value="usuario">Usuario</option>
                            <!-- <option value="descripcion">Descripción</option> -->
                        </select>
                        <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="mostrarUsuario(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                    </div>
                    <!-- fin del buscador segundo -->
                    <!-- TABLA -->
                    <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                        <thead class="enc-tabla">
                            <tr>
                                <th>Opciones</th>
                                <th>Usuarios</th>
                                <th>Empleado</th>
                                <th>Rol</th>
                                <th>Estados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="usuario in Usuarios" :key="usuario.id" :style="usuario.state=='Activo'?'color:black':'color:red'">
                                <td>
                                    <button class="boton boton-edit" @click="abrirModal('usuario','actualizar', usuario)" v-if="$can('acceso.update')"><i class="fa fa-pencil"></i></button>
                                    <template v-if="usuario.state == 'Activo'">
                                        <button class="boton boton-eliminar" @click="desactivarUsuario(usuario.id)" v-if="$can('acceso.inactive')"><i class="fa fa-trash"></i></button>
                                    </template>
                                    <template v-else>
                                        <button class="boton boton-activar" @click="activarUsuario(usuario.id)" v-if="$can('acceso.active')"><i class="fa fa-check-circle"></i></button>
                                    </template>
                                </td>
                                <td v-text="usuario.name"></td>
                                <td v-text="usuario.Empleado"></td>
                                <td v-text="usuario.rol"></td>
                                <td v-text="usuario.state"></td>
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
                idUsuario: 0,
                usuario: '',
                password: '',
                rol: '',
                idEmpleado: 0,
                Usuarios: [],
                infoEmpleado: [],
                modal: 0,
                tituloModal: '',
                btnFuncion: 0,
                errorUsuario: 0,
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
                criterio: 'Usuario',
                buscar: '',
                listaRoles: [],
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
            mostrarUsuario(pagina,buscar,criterio){
                let me = this;
                var url= '/acceso?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.Usuarios = respuesta.accesos.data;
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
            mostrarRoles(){
                let me = this;
                var url= '/roles/lista';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.listaRoles = respuesta.roles;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarUsuario(){
                if(this.validarFrmUsuario()){
                    return;
                }
                else{
                    let me = this;
                    axios.post('/acceso/registrar', {
                        'idEmpleado': this.idEmpleado,
                        'Usuario' : this.usuario, 
                        'password' : this.password,
                        'Rol' : this.rol
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarUsuario(1,'','Usuario');
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            actualizarUsuario(){
                if(this.validarFrmUsuario()){
                    return;
                }
                else{
                    let me = this;
                    axios.put('/acceso/actualizar', {
                        'id' : this.idUsuario, 
                        'idEmpleado' : this.idEmpleado,
                        'Usuario' : this.usuario, 
                        'password' : this.password,
                        'Rol' : this.rol
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarUsuario(1,'','Usuario');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            validarFrmUsuario(){
                this.errorUsuario=0;
                this.msjErrores= [];

                if(this.idEmpleado == 0){
                    this.msjErrores.push("* Debe seleccionar una opción en el empleado");
                } else if(this.usuario == ''){
                    this.msjErrores.push("* El campo usuario no puede estar vacío"); 
                } else if (this.password.length < 8) { 
                    this.msjErrores.push("* La contraseña debe de tener como mínimo 8 caracteres");
                }else if (this.password == '') { 
                    this.msjErrores.push("* La contraseña no puede estar vacía");
                }else if (this.rol == '') { 
                    this.msjErrores.push("* Debe seleccionar una opción en el rol");
                }

                if(this.msjErrores.length) 
                {
                    this.errorUsuario= 1;
                }
                return this.errorUsuario;
            },
            activarUsuario(id){
                swal({
                    title: '¿Estas seguro?',
                    text: 'Deseas activar este Usuario',
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
                            axios.put('/acceso/activar', {'id' : id}).then(function(response) {
                                me.mostrarUsuario(1,'','Usuario');
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
            desactivarUsuario(id){
                swal({
                    title: '¿Estas seguro?',
                    text: 'Deseas desactivar este Usuario',
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
                            axios.put('/acceso/desactivar', {'id' : id}).then(function(response) {
                                me.mostrarUsuario(1,'','Usuario');
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
                me.mostrarUsuario(pagina,buscar,criterio);
            },
            abrirModal(modelo, accion, data=[]){
                switch (modelo) {
                    case "usuario":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Usuario';
                                this.idEmpleado = 0;
                                this.usuario = '';
                                this.password = '';
                                this.rol = '';
                                this.btnFuncion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Usuario';
                                this.btnFuncion = 2;
                                this.idUsuario = data['id'];
                                this.idEmpleado = data['idEmpleado'];
                                this.usuario = data['name'];
                                this.password = '';
                                this.rol = data['idrol'];
                                break;
                            }
                        }
                    }
                }

                this.mostrarEmpleado();
                this.mostrarRoles();
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.idEmpleado = 0;
                this.usuario = '';
                this.password = '';
                this.rol = '';
                this.msjErrores = [];
                this.errorUsuario = 0;
            },         
        },
        mounted() {
            this.mostrarUsuario(1,this.buscar,this.criterio);
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
