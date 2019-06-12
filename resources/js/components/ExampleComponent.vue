<template>
    <section class="main-section col-md-10 col-sm-12 d-flex ml-auto" id="SectionCuerpo">
        <div class="section-contenido mt-4 ml-2 mr-4 mb-4" id="contenido">
        <!-- ENCABEZADO -->
            <div class="contenido__encabezado bg-primary d-flex w-100" id="contenido-enc">
                <h5 class="titulo">Opcion 1</h5>
            <!-- Boton nuevo -->
                <button class="btn-new" data-toggle="modal" data-target="#btn-new"><i class="fa fa-plus-circle"></i> Nuevo</button>
                <!-- Modal del Nuevo -->
                <div class="modal fade" id="btn-new" tabindex="-1" role="dialog" aria-labelledby="btn-new" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-white">Agregar Opcion 1</h5>
                                <button class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-group">
                                        <label for="nombre">Nombre: </label>
                                        <input type="text" class="form-control" placeholder="Nombre...">
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha">Fecha: </label>
                                        <input type="text"  class="form-control" id="dpFecha" placeholder="dd/mm/yyyy">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success"><i class="fa fa-check"></i> Aceptar</button>
                                <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Cerrar</button>
                            </div>    
                        </div>
                    </div>
                </div>
                <!-- buscador -->
                <div class="buscador d-flex ml-auto hidden-md-down">
                    <label for="" class="etiqueta">Buscar por: </label>
                    <select name="filtro" id="" class="option-search">
                        <option value="nombre">Nombre</option>
                        <option value="descripcion">Descripción</option>
                    </select>
                <input type="text" name="buscar" id="buscar" class="buscar" placeholder="Buscar...">
                <div class="icon-buscar">
                    <i class="fa fa-search hidden-md-down"></i>
                </div> 
                </div>
            </div>
            <!-- CUERPO -->
            <div class="contenido__cuerpo" id="cuerpo-contenido">
                <div class="table-responsive tabla-contenido">
                    <!-- Buscar  -->
                    <div class="form-inline mt-2 mb-2">
                        <label for="buscar" class="hidden-lg-up ml-1">Buscar por: </label>
                        <select name="" id="select-opciones" class="custom-select hidden-lg-up mb-1 mr-1 w-25">
                            <option value="nombre">Nombre</option>
                            <option value="descripcion">Descripción</option>
                        </select>
                        <input type="text" name="buscar" id="txtbuscar" class="form-control hidden-lg-up mb-1 w-50" placeholder="Buscar...">
                    </div>

                    <!-- TABLA -->
                    <table class="tablesorter table table-striped table-hover table-sm" id="tabla">
                        <thead class="enc-tabla">
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <button class="boton boton-edit" data-toggle="modal" data-target="#btn-modificar"><i class="fa fa-pencil"></i></button>
                                    <!-- MODAL MODIFICAR REGISTRO -->
                                    <div class="modal fade" id="btn-modificar" tabindex="-1" role="dialog" aria-labelledby="btn-modificar" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title text-white">Editar Opcion 1</h5>
                                                    <button class="close" data-dismiss="modal" aria-label="Cerrar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="">
                                                        <div class="form-group">
                                                            <label for="nombre">Nombre: </label>
                                                            <input type="text" class="form-control" placeholder="Nombre...">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fecha">Fecha: </label>
                                                            <input type="text"  class="form-control" id="dpFecha1" placeholder="dd/mm/yyyy">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"><i class="fa fa-check"></i> Aceptar</button>
                                                    <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Cerrar</button>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                    <!-- FIN DE MODIFICAR REGISTRO -->
                                    <button class="boton boton-eliminar" data-toggle="modal" data-target="#btn-eliminar"><i class="fa fa-remove"></i></button>
                                    <!-- MODAL ELIMINAR REGISTRO -->
                                    <div class="modal fade" id="btn-eliminar" tabindex="-1" role="dialog" aria-labelledby="btn-eliminar" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title text-white">Eliminar Opcion 1</h5>
                                                    <button class="close" data-dismiss="modal" aria-label="Cerrar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>¿Seguro desea eliminar la Opcion 1 <b>Lucie Marvin</b>?</h6>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"><i class="fa fa-check"></i> Aceptar</button>
                                                    <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Cerrar</button>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                <!-- FIN DE ELIMINAR REGISTRO -->
                                </td>
                                <td>Lucie Marvin</td>
                                <td>Trantow Road 39375 Mariah Burgs</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td><button class="boton boton-edit"><i class="fa fa-pencil"></i></button> <button class="boton boton-eliminar"><i class="fa fa-times"></i></button></td>
                                <td>Katelyn Grady</td>
                                <td>Champlin Forges, 07420 Gerardo Parkway</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td><button class="boton boton-edit"><i class="fa fa-pencil"></i></button> <button class="boton boton-eliminar"><i class="fa fa-times"></i></button></td>
                                <td>Amanda Kihn</td>
                                <td>Terry Mountain, 58681 Hackett Greens</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td><button class="boton boton-edit"><i class="fa fa-pencil"></i></button> <button class="boton boton-eliminar"><i class="fa fa-times"></i></button></td>
                                <td>Miss Alejandrin Nikolaus</td>
                                <td>Bettye Plaza, 6568 Ned Square</td>
                                <td>Inactivo</td>
                            </tr>
                            <tr>
                                <td><button class="boton boton-edit"><i class="fa fa-pencil"></i></button> <button class="boton boton-eliminar"><i class="fa fa-times"></i></button></td>
                                <td>Emery Sporer IV</td>
                                <td>Senger Ports, 8047 Gulgowski Estates</td>
                                <td>Inactivo</td>
                            </tr>
                            <tr>
                                <td><button class="boton boton-edit"><i class="fa fa-pencil"></i></button> <button class="boton boton-eliminar"><i class="fa fa-times"></i></button></td>
                                <td>Cara Brekke</td>
                                <td>Rathton,1560 Mohr Motorway</td>
                                <td>Activo</td>
                            </tr>
                            <tr>
                                <td><button class="boton boton-edit"><i class="fa fa-pencil"></i></button> <button class="boton boton-eliminar"><i class="fa fa-times"></i></button></td>
                                <td>Charity Kohler</td>
                                <td>Port Ella, 24495 Fahey Centers</td>
                                <td>Inactivo</td>
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
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
