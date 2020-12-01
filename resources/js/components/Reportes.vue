<template>  
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="mt-4 ml-2 mr-4 mb-4" id="contenido">
            <div class="section-contenido">
                <!-- ENCABEZADO -->
                <div class="contenido__encabezado w-100" id="contenido-enc">
                    <h5 class="titulo" style="color: black">Reportes</h5>
                </div>
                <!-- CUERPO -->
                <div class="contenido__cuerpo" id="cuerpo-contenido">
                    <div class="col-md-12">
                        <ul>
                            <li><a href="#" @click="abrirModal('reportes','calendario')">Calendario de Cobro</a></li>
                            <li><a href="#" @click="abrirModal('reportes','recibosall')">Listado de Recibos</a></li>
                            <li><a href="#" @click="abrirModal('reportes','facturas')">Listado de Facturas</a></li>
                            <li><a href="#" @click="abrirModal('reportes','recibos')">Listado de Recibos por Colector</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Abrir Modal-->
            <div class="modal fade" id="btn-new" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="btn-new" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title text-white" v-text="tituloModal"></h5>
                            <button class="close" aria-label="Cerrar" @click="cerrarModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Agragar o actualizar cliente -->
                            <div class="row" v-if="btnFuncion==1">
                                <div class="col-12 col-lg-12">
                                    <label for="nombre">Colector: </label>
                                    <v-select 
                                        label="Nombre"
                                        placeholder="Seleccione Colector"
                                        :options="arrayColector"
                                        v-model="colector"
                                        :reduce="arrayColector => arrayColector.id"
                                    >
                                    </v-select>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label>Fecha Inicio: </label>
                                    <input type="date" class="form-control" :min="fhoy" v-model="finicio">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label>Fecha Fin: </label>
                                    <input type="date" class="form-control" :min="fhoy" v-model="ffin">
                                </div>
                            </div>
                            <!-- Mostrar datos del cliente  -->
                            <div class="row" v-else-if="btnFuncion == 2">
                                <div class="col-12 col-lg-12">
                                    <label for="nombre">Colector: </label>
                                    <v-select 
                                        label="Nombre"
                                        placeholder="Seleccione Empleado"
                                        :options="arrayColector"
                                        v-model="colector"
                                        :reduce="arrayColector => arrayColector.id"
                                    >
                                    </v-select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Fecha Inicio:</label>
                                    <input type="date" v-model="finicio" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Fecha Fin:</label>
                                    <input type="date" v-model="ffin" :min="fechaAct"  class="form-control">
                                </div>
                            </div>
                            <!-- Mostrar datos del cliente  -->
                            <div class="row" v-else-if="btnFuncion == 3 || btnFuncion == 4">
                                <div class="col-md-6">
                                    <label for="">Fecha Inicio:</label>
                                    <input type="date" v-model="finicio" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Fecha Fin:</label>
                                    <input type="date" v-model="ffin" :min="fechaAct"  class="form-control">
                                </div>
                            </div>
                            <div v-show="errorCliente" class="form-group msjerror">
                                <div class="text-center texterror" v-for="error in msjErrores" :key="error" v-text="error">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" v-if="btnFuncion == 4" @click="PrintRecibosAll(finicio, ffin)"><i class="fa fa-print"></i> Imprimir</button>
                            <button class="btn btn-success" v-if="btnFuncion == 3" @click="PrintFactura(finicio, ffin)"><i class="fa fa-print"></i> Imprimir</button>
                            <button class="btn btn-success" v-if="btnFuncion == 1" @click="PrintCalendario(colector, finicio, ffin)"><i class="fa fa-print"></i> Imprimir</button>
                            <button class="btn btn-success" v-if="btnFuncion == 2" @click="listadoRecibo(colector, finicio, ffin)"><i class="fa fa-print"></i> Imprimir</button>
                            <button class="btn btn-danger" @click="cerrarModal()"><i class="fa fa-remove"></i> Cerrar</button>
                        </div>    
                    </div>
                </div>
            </div>
            <!-- Fin del modal -->
        </div>
    </section>

</template>

<script>
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    export default {
        data(){
            return{
                arraycobros: [],
                btnFuncion: 0,
                modal: 0,
                colector: '',
                finicio: '',
                ffin: '',
               fhoy: '',
               arrayColector: [],
               errores: 0,
               msjErrores: [],
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
        methods: {
            DiaActual(){
                let me = this;
                var url= '/inicio/fecha';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                        me.finicio = respuesta.fecha;   
                        me.ffin = respuesta.fecha;   
                        me.fhoy = respuesta.fecha;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarColector(){
                let me = this;
                var url= '/empleado/colector';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arrayColector = respuesta.empleados;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            mostrarEmpleado(){
                let me = this;
                var url= '/empleado/seleccionarEmpleado';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arrayColector = respuesta.empleados;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrirModal(modelo, accion, data=[]){
                switch (modelo) {
                    case "reportes":
                    {
                        switch (accion) {
                            case 'calendario':
                            {
                                this.mostrarColector();
                                this.modal = 1;
                                this.btnFuncion = 1;
                                this.tituloModal = 'Calendario de Cobro';
                                break;
                            }
                            case 'recibos':
                            {
                                this.mostrarEmpleado();
                                this.modal = 1;
                                this.DiaActual();
                                this.tituloModal = 'Listado de Recibo por Colector';
                                this.btnFuncion = 2;
                                break;
                            }
                            case 'facturas':
                            {
                                this.modal = 1;
                                this.DiaActual();
                                this.tituloModal = 'Listado de Facturas';
                                this.btnFuncion = 3;
                                break;
                            }
                            case 'recibosall':
                            {
                                this.modal = 1;
                                this.DiaActual();
                                this.tituloModal = 'Listado de Recibo';
                                this.btnFuncion = 4;
                                break;
                            }
                        }
                    }
                }

                this.cobrosDias();
            },
            PrintCalendario(id, f1, f2){
                if(this.validarFrmFinanciamiento()){
                    return;
                }
                window.open('http://127.0.0.1:8000/print/calendario/'+id+'/'+f1+'/'+f2);
                this.cerrarModal();
            },
            listadoRecibo(id, f1, f2){
                if(this.validarFrmFinanciamiento()){
                    return;
                }
                window.open('http://127.0.0.1:8000/print/listadorecibo/'+id+'/'+f1+'/'+f2);
                this.cerrarModal();
            },
            PrintFactura(f1, f2){
                window.open('http://127.0.0.1:8000/print/listadofacturas/'+f1+'/'+f2);
                this.cerrarModal();
            },
            PrintRecibosAll(f1, f2){
                window.open('http://127.0.0.1:8000/print/listadorecibotodos/'+f1+'/'+f2);
                this.cerrarModal();
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.colector = null;
                this.finicio = this.fhoy;
                this.ffin = this.fhoy;
                this.arrayColector= [];
                this.msjErrores = [];
                this.errorCliente = 0;
            }, 
            validarFrmFinanciamiento(){
                this.errores=0;
                this.msjErrores= [];
                
                if(this.finicio == ''){
                    this.msjErrores.push("* Seleccione un fecha de inicio");
                }else if(this.ffin == ''){
                    this.msjErrores.push("* Seleccione una fecha final");
                }else if(this.ffin < this.finicio){
                    this.msjErrores.push("* La fecha final no puede ser menor a la de inicio");
                }

                if(this.msjErrores.length) 
                {
                    this.errores= 1;
                }
                return this.errores;
            },
        },
        mounted() {
            this.DiaActual();
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
    .w-22{
        width: 22%
    }

    @media screen and (max-width: 767px) {
        .w-22{
            width: 100%;
        }
    }
</style>