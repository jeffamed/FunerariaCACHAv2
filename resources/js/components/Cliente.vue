<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Clientes</h5>
            <!-- Boton nuevo -->
                <button class="btn-new"  @click="abrirModal('cliente','registrar')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
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
                                    <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <label for="nombre">Nombres: </label>
                                                <input type="text" class="form-control" placeholder="Nombre..." v-model="nombre" required>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="apellido">Apellidos: </label>
                                                <input type="text" class="form-control" placeholder="Apellidos..." v-model="apellido" required>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <label for="telefono">Teléfono: </label>
                                                <input type="text" class="form-control" placeholder="8123-4567" pattern="[0-9]{4}-[0-9]{4}" v-model="telefono" required>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <label for="cedula">Cédula: </label>
                                                <input type="text" class="form-control" placeholder="000-000000-0000X" pattern="[0-9]{3}-[0-9]{6}-[0-9]{4}[A-Z]{1}" v-model="cedula" required>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <label for="estadocivil">Estado Civil: </label>
                                                <select class="form-control" v-model="estadoCivil">
                                                    <option value="" disabled>Seleccione...</option>
                                                    <option value="Soltero">Soltero</option>
                                                    <option value="Casado">Casado</option>
                                                    <option value="Viudo">Viudo</option>
                                                    <option value="Divorciado">Divorciado</option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-lg-6">
                                                <label for="barrio">Barrio: </label>
                                                <select class="form-control" v-model="idBarrio">
                                                    <option value="0" disabled>Seleccione...</option>
                                                    <option v-for="barrio in infoBarrio" :key="barrio.id" :value="barrio.id" v-text="barrio.Nombre"></option>
                                                </select>
                                            </div>
                                            <div class="col-lg-12">
                                                <label for="direccion">Dirección: </label>
                                                <textarea class="form-control" v-model="direccion" required></textarea>
                                            </div>
                                    </div>
                                    <div v-show="errorCliente" class="form-group msjerror">
                                        <div class="text-center texterror" v-for="error in msjErrores" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" v-if="btnFuncion == 1" @click="registrarCliente()"><i class="fa fa-check"></i> Guardar</button>
                                <button class="btn btn-success" v-if="btnFuncion == 2" @click="actualizarCliente()"><i class="fa fa-check"></i> Actualizar</button>
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
                    <input type="text" v-model="buscar" @keyup="mostrarCliente(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
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
                        <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="mostrarCliente(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                    </div>
                    <!-- fin del buscador segundo -->
                    <!-- TABLA -->
                    <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                        <thead class="enc-tabla">
                            <tr>
                                <th>Opciones</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Teléfono</th>
                                <th>Barrio</th>
                                <th>Dirección</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cliente in Clientes" :key="cliente.id">
                                <td>
                                    <button class="boton boton-edit" @click="abrirModal('cliente','actualizar', cliente)"><i class="fa fa-pencil"></i></button>
                                    <button class="boton boton-mirar" @click="abrirModal('cliente','actualizar', cliente)"><i class="fa fa-eye"></i></button>
                                </td>
                                <td v-text="cliente.Nombre"></td>
                                <td v-text="cliente.Apellido"></td>
                                <td v-text="cliente.Telefono"></td>
                                <td v-text="cliente.Barrio"></td>
                                <td v-text="cliente.Direccion"></td>
                                <td v-text="cliente.Estado"></td>
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
                idCliente: 0,
                idBarrio: 0,
                nombre: '',
                apellido: '',
                telefono: '',
                cedula: '',
                direccion: '',
                estadoCivil: '',
                infoBarrio: [],
                Clientes: [],
                modal: 0,
                tituloModal: '',
                btnFuncion: 0,
                errorCliente: 0,
                msjErrores: [],
                pagination: {
                    'total': 0,    
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                    'page':1,
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
            mostrarCliente(pagina,buscar,criterio){
                let me = this;
                var url= '/cliente?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.Clientes = respuesta.clientes.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarBarrio(){
                let me = this;
                var url= '/barrio/seleccionarBarrio';
                axios.get(url).then(function(response) {
                    // console.log(response);
                    var respuesta = response.data;
                    me.infoBarrio = respuesta.barrios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(pagina,buscar,criterio){
                let me = this;
                me.pagination.current_page = pagina;
                me.mostrarCliente(pagina,buscar,criterio);
            },
            registrarCliente(){
                if(this.validarFrmCliente()){
                    return;
                }
                else{
                    let me = this;
                    axios.post('/cliente/registrar', {
                        'idBarrio' : this.idBarrio,
                        'Nombre' : this.nombre,
                        'Apellido' : this.apellido,
                        'Telefono' : this.telefono,
                        'Estado_Civil' : this.estadoCivil,
                        'Cedula' : this.cedula,
                        'Direccion' : this.direccion
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarCliente(1,'','Nombre');
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            actualizarCliente(){
                if(this.validarFrmCliente()){
                    return;
                }
                else{
                    let me = this;
                    axios.put('/cliente/actualizar', {
                        'id' : this.idCliente,
                        'idBarrio' : this.idBarrio,
                        'Nombre' : this.nombre,
                        'Apellido' : this.apellido,
                        'Direccion' : this.direccion,
                        'Estado_Civil' : this.estadoCivil,
                        'Telefono' : this.telefono,
                        'Cedula' : this.cedula
                        }).then(function(response) {
                        me.cerrarModal();
                        me.mostrarCliente(1,'','Nombre');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            validarFrmCliente(){
                this.errorCliente=0;
                this.msjErrores= [];

                if(this.nombre == ''){
                    this.msjErrores.push("* El campo nombre no puede estar vacío");
                }else if(this.apellido == ''){
                    this.msjErrores.push("* El campo apellido no puede estar vacío");
                }else if(this.telefono == ''){
                    this.msjErrores.push("* El campo telefono no puede estar vacío o el formato no es valido");
                }else if(this.cedula == ''){
                    this.msjErrores.push("* El campo cedulo no puede estar vacío o el formato no es valido");
                }else if(this.direccion == ''){
                    this.msjErrores.push("* El campo direccion no puede estar vacío");
                }
                else if(this.estadoCivil == ''){
                    this.msjErrores.push("* Seleccione una opción de estado civil");
                }else if(this.idBarrio == 0){
                    this.msjErrores.push("* Seleccione una opción de barrio");
                }

                if(this.msjErrores.length) 
                {
                    this.errorCliente= 1;
                }
                return this.errorCliente;
            },
            abrirModal(modelo, accion, data=[]){
                switch (modelo) {
                    case "cliente":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Cliente';
                                this.nombre = '';
                                this.apellido = '';
                                this.telefono = '';
                                this.cedula = '';
                                this.direccion = '';
                                this.estadoCivil = '';
                                this.idBarrio = 0;
                                this.btnFuncion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Cliente';
                                this.btnFuncion = 2;
                                this.idCliente = data['id'];
                                this.idBarrio = data['idBarrio'];
                                this.nombre = data['Nombre'];
                                this.apellido = data['Apellido'];
                                this.direccion = data['Direccion'];
                                this.estadoCivil = data['Estado_Civil'],
                                this.telefono = data['Telefono'];
                                this.cedula = data['Cedula'];
                                break;
                            }
                        }
                    }
                }

                this.mostrarBarrio();
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.idCliente = 0;
                this.idBarrio = 0;
                this.nombre = '';
                this.apellido= '';
                this.direccion = '';
                this.estadoCivil = '';
                this.telefono = '';
                this.cedula = '';
                this.msjErrores = [];
                this.errorCliente = 0;
            },         
        },
        mounted() {
            this.mostrarCliente(1,this.buscar,this.criterio);
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