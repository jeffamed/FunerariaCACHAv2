<template>  
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="mt-4 ml-2 mr-4 mb-4" id="contenido">
            <div class="section-contenido">
                <!-- ENCABEZADO -->
                <div class="contenido__encabezado bg-primary w-100" id="contenido-enc">
                    <h5 class="titulo text-center">Estado de Cuenta</h5>
                </div>
                <!-- CUERPO -->
                <div class="contenido__cuerpo" id="cuerpo-contenido">
                    <div class="row">
                    <!-- Cliente -->
                        <div class="col-md-10 form-group">
                            <label for="Cliente" class="form-control-label">Cliente:</label>
                            <v-select 
                                label="Nombre"
                                placeholder="Buscar Cliente.."
                                :options="infoCliente"
                                v-model="cliente"
                                :value="infoCliente"
                                @input="setCliente"
                            >
                            </v-select>
                        </div>
                        <div class="col-md-1 my-auto">
                            <button class="btn btn-warning" @click="ImprimirEstado(idCliente)"><span class="fa fa-print"></span></button>
                        </div>
                    </div>
                    <div class="table-responsive tabla-contenido">
                        <!-- TABLA -->
                        <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                            <thead class="enc-tabla">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Deuda</th>
                                    <th class="text-center">Abono</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="cliente == ''">
                                    <td colspan="5" class="text-center" style="font-weight: 700">*** Seleccione un Cliente ***</td>
                                </tr>
                                <tr v-else-if="arrayEstado.length == 0">
                                    <td colspan="5" class="text-center" style="font-weight: 700; color: orange">*** El cliente no tiene contrato ***</td>
                                </tr>
                                <tr v-for="est in arrayEstado" :key="est" :style="parseFloat(est.Deuda) > 0?'font-weight: 800':''">
                                    <td v-text="est.Fecha"></td>
                                    <td v-text="est.Descripcion"></td>
                                    <td class="text-center" v-text="est.Deuda"></td>
                                    <td class="text-center" v-text="est.Abono"></td>
                                    <td class="text-center" v-text="est.TotalRestante"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                cliente: '',
                idCliente: '',
                Contratos: [],
                arrayEstado: [],
                infoCliente: [],
                errorContrato: 0,
                msjErrores: [],

            }
        },
        components:{
            vSelect
        },
        methods:{
            mostrarCliente(){
                let me = this;
                var url= '/cliente/seleccionarCliente';
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.infoCliente = respuesta.clientes;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            setCliente(values){
                let me = this;
                me.idCliente = values.id;
                me.cliente = values.Nombre;
                me.CargarEstado(me.idCliente);
            },
            CargarEstado(id){
                let me = this;
                var url= '/estadocuenta?idCliente='+id;
                axios.get(url).then(function(response) {
                    var respuesta = response.data;
                    me.arrayEstado = respuesta.estado;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            ImprimirEstado(id){
                window.open('http://127.0.0.1:8000/print/estado/'+id);
            },
            validarFrmContrato(){
                this.errorContrato=0;
                this.msjErrores= [];
                
                if(this.contrato == ''){
                    this.msjErrores.push("* El campo contrato no puede estar vacío");
                }else if(this.idCliente == ''){
                    this.msjErrores.push("* Debe de seleccionar una opción en cliente");
                }else if(this.fechaEmision == ''){
                    this.msjErrores.push("* El campo fecha de emisión no puede estar vacío");
                }

                if(this.msjErrores.length) 
                {
                    this.errorContrato= 1;
                }
                return this.errorContrato;
            },   
        },
        mounted() {
            this.mostrarCliente();
        }
    }
</script>