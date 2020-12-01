<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Tasa de Cambio</h5>
            <!-- Boton nuevo -->
                <button class="btn-new"  @click="abrirModal('cambio','registrar')" v-if="$can('cambio.store')"><i class="hidden-xs-down fa fa-plus-circle"></i> Nuevo</button>
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
                                        <label for="nombre">Monto: </label>
                                        <input type="number" class="form-control" placeholder="00.00" v-model="Monto">
                                    </div>
                                    <div v-show="errorCambio" class="form-group msjerror">
                                        <div class="text-center texterror" v-for="error in msjErrores" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" v-if="btnFuncion == 1" @click="registraCambio()"><i class="fa fa-check"></i> Guardar</button>
                                <button class="btn btn-success" v-if="btnFuncion == 2" @click="actualizarCambio()"><i class="fa fa-check"></i> Actualizar</button>
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
                        <option value="Monto">Monto</option>
                    </select>
                    <input type="text" v-model="buscar" @keyup="mostrarCambio(1,buscar,criterio)" class="buscar" placeholder="Buscar...">
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
                            <option value="Monto">Monto</option>
                        </select>
                        <input type="text" id="txtbuscar" v-model="buscar" @keypress.enter="mostrarCambio(1,buscar,criterio)" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                    </div>
                    <!-- fin del buscador segundo -->
                    <!-- TABLA -->
                    <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                        <thead class="enc-tabla">
                            <tr>
                                <th>Opciones</th>
                                <th>Monto</th>
                                <th>Fecha Ingreso</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cambio in TCambios" :key="cambio.id">
                                <td> 
                                    <button class="boton boton-edit" @click="abrirModal('cambio','actualizar', cambio)" v-if="$can('cambio.update')"><i class="fa fa-pencil"></i></button>
                                </td>
                                <td v-text="cambio.Monto"></td>
                                <td v-text="cambio.created_at"></td>
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
 Alessia Claudine  
<script>
    export default {
        data(){
            return {
                idMonto: 0,
                Monto: '',
                TCambios: [],
                modal: 0,
                tituloModal: '',
                btnFuncion: 0,
                errorCambio: 0,
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
                criterio: 'Monto',
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
            mostrarCambio(pagina,buscar,criterio){
                let me = this;
                var url= '/tasa?page=' + pagina + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.TCambios = respuesta.cambios.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarCambio(){
                if(this.validarFrmCambio()){
                    return;
                }
                else{
                    let me = this;
                    axios.post('/tasa/registrar', {
                        'Monto' : this.Monto, 
                        }).then(function(response) {
                            me.cerrarModal();
                            me.mostrarCambio(1,'','Monto');
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            actualizarCambio(){
                if(this.validarFrmCambio()){
                    return;
                }
                else{
                    let me = this;
                    axios.put('/tasa/actualizar', {
                        'Monto' : this.Monto, 
                        'id' : this.idMonto, 
                        }).then(function(response) {
                            me.cerrarModal();
                            me.mostrarCambio(1,'','Monto');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            validarFrmCambio(){
                this.errorCambio=0;
                this.msjErrores= [];

                if(this.Monto == ''){
                    this.msjErrores.push("* El campo monto no puede estar vacío");
                }
                if(this.msjErrores.length) 
                {
                    this.errorCambio= 1;
                }
                return this.errorCambio;
            },
            cambiarPagina(pagina,buscar,criterio){
                let me = this;
                me.pagination.current_page = pagina;
                me.mostrarCambio(pagina,buscar,criterio);
            },
            abrirModal(modelo, accion, data=[]){
                switch (modelo) {
                    case "cambio":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Tasa Cambio';
                                this.Monto = '';
                                this.btnFuncion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Tasa Cambio';
                                this.btnFuncion = 2;
                                this.idMonto = data['id'];
                                this.Monto = data['Monto'];
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.Monto = '';
                this.msjErrores = [];
                this.errorCambio = 0;
            },         
        },
        mounted() {
            this.mostrarCambio(1,this.buscar,this.criterio);
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
