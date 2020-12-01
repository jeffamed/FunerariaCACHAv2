<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Roles</h5>
            <!-- Boton nuevo -->
                <button class="btn-new"  @click="mostrarFrm('roles','registrar')" v-if="$can('rol.store')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
                <!-- buscador -->
                <div class="buscador d-flex ml-auto hidden-md-down">
                    <label for="" class="etiqueta">Buscar por: </label>
                    <select name="filtro" class="option-search" v-model="criterio">
                        <option value="name">Nombre</option>
                    </select>
                    <input type="text" v-model="buscar" @keyup="mostrarrole(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
                    <div class="icon-buscar">
                        <i class="fa fa-search hidden-md-down"></i>
                    </div> 
                </div>
                <!-- Fin del buscador -->
            </div>
            <!-- CUERPO -->
            <div class="contenido__cuerpo" id="cuerpo-contenido">
                <template v-if="mostrar == 1">
                    <div class="table-responsive tabla-contenido">
                        <!-- Buscador segundo-->
                        <div class="form-inline mt-2 mb-2">
                            <label for="buscar" class="hidden-lg-up ml-1">Buscar por: </label>
                            <select id="select-opciones" class="custom-select hidden-lg-up mb-1 mr-1 w-25" v-model="criterio">
                                <option value="name">Nombre</option>
                            </select>
                            <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="mostrarrole(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                        </div>
                        <!-- fin del buscador segundo -->
                        <!-- TABLA -->
                        <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                            <thead class="enc-tabla">
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombres</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="role in roles" :key="role.id">
                                    <td>
                                        <button class="boton boton-mirar" @click="mostrarFrm('roles','mirar', role)"><i class="fa fa-eye"></i></button>
                                        <button class="boton boton-edit" @click="mostrarFrm('roles','actualizar', role)" v-if="$can('rol.update')"><i class="fa fa-pencil"></i></button>
                                    </td>
                                    <td v-text="role.name"></td>
                                    <td v-text="role.description"></td>
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
                <template v-else>
                    <div class="row m-1" v-if="btnFuncion == 3">
                        <div class="col-md-12">
                            <label for="">Nombre del Rol:</label>
                            <p class="fontperz" v-text="nombre"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="">Descripción del Rol:</label>
                            <p class="fontperz" v-text="descripcion"></p>
                        </div>
                        <div class="col-md-12" style="border-top: 1px solid; border-bottom: 1px solid; padding: 5px; margin-bottom: 1rem">
                            <p class="text-center text-bold">Permisos Asignado</p>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered table-hover table-striped table-sm">
                                <thead>
                                    <th>Permiso</th>
                                    <th>Descripción</th>
                                </thead>
                                <tbody>
                                    <tr v-for="det in permisosAsign" :key="det.id">
                                        <td v-text="det.name"></td>
                                        <td v-text="det.description"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-danger" @click="cerrarFrm()"><i class="fa fa-close"></i>Cancelar</button>
                        </div>
                    </div>
                    <div class="row m-1" v-else>
                        <div class="col-md-12">
                            <label for="">Rol:</label>
                            <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del Role">
                        </div>
                        <div class="col-md-12">
                            <label for="">Descripción:</label>
                            <input type="text" v-model="descripcion" class="form-control" placeholder="Descripción basica del rol">
                        </div>
                        <hr>
                        
                        <div class="col-md-6 mt-1">
                            <label for="">Permisos:</label>
                            <v-select
                                label="Nombre"
                                placeholder= "Seleccione Permisos"
                                :options="optModulo"
                                v-model="modulo"
                                :value="optModulo.code"
                                @input="setPermiso"
                            ></v-select>
                            <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                                <thead>
                                    <th>Opc</th>
                                    <th>Nombre</th>
                                </thead>
                                <tbody v-if="permisos.length > 0">
                                    <tr v-for="permiso in permisos" :key="permiso">
                                        <td>
                                            <button class="boton boton-activar" @click.prevent="agregarPermiso(permiso.id,permiso.name)" v-if="btnFuncion==1"><i class="fa fa-check"></i></button>
                                            <button class="boton boton-activar" @click.prevent="registrarPermiso(permiso.id)" v-else><i class="fa fa-check"></i></button>
                                        </td>
                                        <td v-text="permiso.name"></td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="2" class="text-center">*** SELECCIONE UN MODULO ***</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 mt-1">
                            <label for="">Permisos Asignados</label>
                            <br>
                            <div class="card content table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="tablesorter table table-striped table-hover table-sm" id="tabla" v-show="btnFuncion==1">
                                    <thead>
                                        <th>Opc</th>
                                        <th>Nombre</th>
                                    </thead>
                                    <tbody v-if="permisosAsign.length > 0">
                                        <tr v-for="(permiso, index) in permisosAsign" :key="permiso.idpermiso">
                                            <td @click="eliminarPermiso(index)"><button class="boton boton-eliminar"><i class="fa fa-close"></i></button></td>
                                            <td v-text="permiso.nombre" v-if="btnFuncion==2"></td>
                                            <td v-text="permiso.name" v-else></td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="2" class="text-center">*** EL ROL NO TIENE PERMISO ***</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card content table-wrapper-scroll-y my-custom-scrollbar" v-show="btnFuncion==2">
                                <table class="tablesorter table table-striped table-hover table-sm" id="tabla" v-show="btnFuncion==2">
                                    <thead>
                                        <th>Opc</th>
                                        <th>Nombre</th>
                                    </thead>
                                    <tbody v-if="permisosAsign.length > 0">
                                        <tr v-for="(permiso, index) in permisosAsign" :key="permiso.id">
                                            <td @click="eliminarPermiso(index)" v-if="btnFuncion==1"><button class="boton boton-eliminar"><i class="fa fa-close"></i></button></td>
                                            <td @click.prevent="quitarPermiso(permiso.idpermisorol)" v-else><button class="boton boton-eliminar"><i class="fa fa-close"></i></button></td>
                                            <td v-text="permiso.name"></td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="2" class="text-center">*** EL ROL NO TIENE PERMISO ***</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-success" @click="registrarRole()" v-if="btnFuncion==1"><i class="fa fa-check" ></i> Guardar</button>
                            <button class="btn btn-warning" @click="actualizarRole()" v-if="btnFuncion==2"><i class="fa fa-check" ></i> Actualizar</button>
                            <button class="btn btn-danger" @click="cerrarFrm()"><i class="fa fa-close"></i>Cancelar</button>
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
                idrole: 0,
                nombre: '',
                descripcion: '',
                roles: [],
                permisos: [],
                permisosAsign: [],
                modal: 0,
                tituloModal: '',
                btnFuncion: 0,
                errorrole: 0,
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
                criterio: 'name',
                buscar: '',
                mostrar: 1,
                modulo: '',
                codigo: '',
                optModulo:[{Nombre: 'Recibo', code: 'factura'},{Nombre: 'Contrato', code: 'contrato'},{Nombre: 'Financiar', code: 'financiamiento'},
                    {Nombre: 'Factura', code: 'ventas'},{Nombre: 'Cliente', code: 'cliente'},{Nombre: 'Servicios', code: 'servicio'},
                    {Nombre: 'Proyecto', code: 'proyecto'},{Nombre: 'Barrios', code: 'barrio'},{Nombre: 'Zonas', code: 'zona'},
                    {Nombre: 'Departamentos', code: 'departamento'},{Nombre: 'Municipios', code: 'municipio'},{Nombre: 'Empleados', code: 'empleado'},{Nombre: 'Usuario', code: 'acceso'},
                    {Nombre: 'Roles', code: 'rol'},{Nombre: 'Tasa Cambio', code: 'cambio'}],
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
            mostrarrole(pagina,buscar,criterio){
                let me = this;
                var url= '/role?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.roles = respuesta.roles.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            setPermiso(value){
                let me = this;
                me.loading = true;
                me.codigo = value.code;
                if(me.btnFuncion == 1){
                    me.listarPermisos(value.code);
                }else{
                    me.permisosDisponible(value.code, me.idrole);
                }
            },
            listarPermisos(buscar){
                let me = this;
                var url= '/permiso/listar?Buscar='+buscar;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.permisos = respuesta.permisos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            permisosDisponible(buscar, id){
                let me = this;
                var url= '/permiso/disponible?slug='+buscar+'&idrol='+id;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.permisos = respuesta.permisos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            cambiarPagina(pagina,buscar,criterio){
                let me = this;
                me.pagination.current_page = pagina;
                me.mostrarrole(pagina,buscar,criterio);
            },
            agregarPermiso(id, name){
                let me = this;
                me.permisosAsign.push({
                    idpermiso : id,
                    name : name
                });
            },
            eliminarPermiso(index){
                let me = this;
                me.permisosAsign.splice(index, 1);
            },
            rolesAsignados(buscar){
                let me = this;
                var url= '/permiso/listarAsign?id='+buscar;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.permisosAsign = respuesta.permisos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            quitarPermiso(id){
                if(this.validarFrmrole()){
                    return;
                }
                else{
                    let me = this;
                    axios.delete('/permiso/eliminar/'+id,{})
                    .then(function(response) {
                        me.rolesAsignados(me.idrole);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            registrarPermiso(id){
                let me = this;
                axios.post('/permiso/registrar', {
                    'idpermiso' : id,
                    'rol': me.idrole
                    }).then(function(response) {
                        me.rolesAsignados(me.idrole); 
                        me.permisosDisponible(me.codigo, me.idrole);
                    })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarRole(){
                if(this.validarFrmrole()){
                    return;
                }
                else{
                    let me = this;
                    axios.post('/role/registrar', {
                        'Nombre' : this.nombre,
                        'Descripcion' : this.descripcion,
                        'data': this.permisosAsign,
                        }).then(function(response) {
                            me.cerrarFrm();
                            me.mostrarrole(1,'','Nombre');
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            actualizarRole(){
                if(this.validarFrmrole()){
                    return;
                }
                else{
                    let me = this;
                    axios.put('/role/actualizar', {
                        'Nombre' : this.nombre,
                        'Descripcion' : this.descripcion,
                        'id' : this.idrole
                        }).then(function(response) {
                        me.cerrarFrm();
                        me.mostrarrole(1,'','Nombre');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            validarFrmrole(){
                this.errorrole=0;
                this.msjErrores= [];

                if(this.nombre == ''){
                    this.msjErrores.push("* El campo nombre no puede estar vacío");
                }else if(this.descripcion == ''){
                    this.msjErrores.push("* El campo descripción no puede estar vacío");
                }

                if(this.msjErrores.length) 
                {
                    this.errorrole= 1;
                }
                return this.errorrole;
            },
            mostrarFrm(modelo, accion, data=[]){
                this.mostrar= 2;
                switch (modelo) {
                    case "roles":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.tituloModal = 'Registrar Role';
                                this.nombre = '';
                                this.descripcion= '';
                                this.btnFuncion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.tituloModal = 'Actualizar Role';
                                this.btnFuncion = 2;
                                this.idrole = data['id'];
                                this.nombre = data['name'];
                                this.descripcion= data['description'];
                                this.rolesAsignados(this.idrole); 
                                break;
                            }
                            case 'mirar':
                            {
                                this.btnFuncion = 3;
                                this.tituloModal = 'Datos del Rol';
                                this.idrole = data['id'];
                                this.nombre = data['name'];
                                this.descripcion= data['description'];
                                this.rolesAsignados(this.idrole); 
                                break;
                            }
                        }
                    }
                }
            },
            cerrarFrm(){
                this.mostrar = 1;
                this.btnFuncion = 0;
                this.tituloModal = '';
                this.idrole= '';
                this.nombre = '';
                this.descripcion= '';
                this.permisos= [];
                this.permisosAsign= [];
                this.modulo= '';
                this.msjErrores = [];
                this.errorrole = 0;
            },         
        },
        mounted() {
            this.mostrarrole(1,this.buscar,this.criterio);
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
    .my-custom-scrollbar {
        position: relative;
        min-height: 10vh;
        max-height: 35vh;
        overflow: auto;
    }
    .table-wrapper-scroll-y {
        display: block;
    }
</style>

