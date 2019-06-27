<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Departamentos</h5>
            <!-- Boton nuevo -->
                <button class="btn-new"  @click="abrirModal('departamento','registrar')"><i class="fa fa-plus-circle"></i> Nuevo</button>
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
                                        <input type="text" class="form-control" placeholder="Nombre..." v-model="nombre">
                                        <small class="form-text text-muted">* Ingrese un departamento ejm.: Managua</small>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" v-if="btnFuncion == 1" @click="registrarDepartamento()"><i class="fa fa-check"></i> Guardar</button>
                                <button class="btn btn-success" v-if="btnFuncion == 2" @click="actualizarDepartamento()"><i class="fa fa-check"></i> Actualizar</button>
                                <button class="btn btn-danger" @click="cerrarModal()"><i class="fa fa-remove"></i> Cerrar</button>
                            </div>    
                        </div>
                    </div>
                </div>
                <!-- Fin del modal -->
                <!-- buscador -->
                <div class="buscador d-flex ml-auto hidden-md-down">
                    <label for="" class="etiqueta">Buscar por: </label>
                    <select name="filtro" id="" class="option-search">
                        <option value="nombre">Nombre</option>
                        <!-- <option value="descripcion">Descripción</option> -->
                    </select>
                    <input type="text" name="buscar" id="buscar" class="buscar" placeholder="Buscar...">
                    <div class="icon-buscar">
                        <i class="fa fa-search hidden-md-down"></i>
                    </div> 
                </div>
                <!-- Fin del buscador -->
            </div>
            <!-- CUERPO -->
            <div class="contenido__cuerpo" id="cuerpo-contenido">
                <div class="table-responsive tabla-contenido">
                    <!-- Buscar  segundo-->
                    <div class="form-inline mt-2 mb-2">
                        <label for="buscar" class="hidden-lg-up ml-1">Buscar por: </label>
                        <select name="" id="select-opciones" class="custom-select hidden-lg-up mb-1 mr-1 w-25">
                            <option value="nombre">Nombre</option>
                            <option value="descripcion">Descripción</option>
                        </select>
                        <input type="text" name="buscar" id="txtbuscar" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                    </div>
                    <!-- fin del buscador segundo -->
                    <!-- TABLA -->
                    <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                        <thead class="enc-tabla">
                            <tr>
                                <th>Opciones</th>
                                <th>Departamentos</th>
                                <th>Estados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="departamento in Departamentos" :key="departamento.id">
                                <td>
                                    <button class="boton boton-edit" @click="abrirModal('departamento','actualizar',departamento)"><i class="fa fa-pencil"></i></button>
                                    <button class="boton boton-eliminar" data-toggle="modal" data-target="#btn-eliminar"><i class="fa fa-remove"></i></button>
                                </td>
                                <td v-text="departamento.Nombre"></td>
                                <td v-text="departamento.Estado"></td>
                            </tr>
                           
                        </tbody>
                    </table>
                </div>

                <!-- PAGINACION -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end" id="pagination">
                        <li class="page-item"><a href="#" class="page-link"><span>&laquo;</span> Ant</a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">Sig <span>&raquo;</span></a></li>
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
                nombre: '',
                Departamentos: [],
                modal: 0,
                tituloModal: '',
                btnFuncion: 0,
            }
        },
        methods:{
            mostrarDepartamento(){
                let me = this;
                axios.get('/departamento').then(function(response) {
                    me.Departamentos = response.data;
                    // console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarDepartamento(){
                let me = this;
                axios.post('/departamento/registrar', {'Nombre' : this.nombre}).then(function(response) {
                    me.cerrarModal();
                    me.mostrarDepartamento();
                 })
                .catch(function (error) {
                    console.log(error);
                });
            },
            actualizarDepartamento(){

            },
            abrirModal(modelo, accion, data=[]){
                switch (modelo) {
                    case "departamento":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Departamento';
                                this.nombre = '';
                                this.btnFuncion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
								this.modal = 1;
                                this.tituloModal = 'Actualizar Departamento';
                                this.btnFuncion = 2;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
            },         
        },
        mounted() {
            this.mostrarDepartamento();
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
</style>
