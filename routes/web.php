<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layout/contenido');
});
Route::middleware(['guest'])->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/', function () {
        return view('layout/contenido');
    })->name('main')->where('path', '.*');

Route::get('scraping','DashboardController@Tasa');

Route::get('/departamento','DepartamentosController@index')->name('departamento.index')->middleware('permission:departamento.index');
Route::post('/departamento/registrar','DepartamentosController@store')->name('departamento.store')->middleware('permission:departamento.store');
Route::put('/departamento/actualizar','DepartamentosController@update')->name('departamento.update')->middleware('permission:departamento.update');
Route::put('/departamento/desactivar','DepartamentosController@desactivar')->name('departamento.inactive')->middleware('permission:departamento.inactive');
Route::put('/departamento/activar','DepartamentosController@activar')->name('departamento.active')->middleware('permission:departamento.active');
Route::get('/departamento/seleccionarDepartamento','DepartamentosController@seleccionar');

Route::get('/municipio','MunicipiosController@index')->name('municipio.index')->middleware('permission:municipio.index');
Route::post('/municipio/registrar','MunicipiosController@store')->name('municipio.store')->middleware('permission:municipio.store');
Route::put('/municipio/actualizar','MunicipiosController@update')->name('municipio.update')->middleware('permission:municipio.update');
Route::put('/municipio/desactivar','MunicipiosController@desactivar')->name('municipio.inactive')->middleware('permission:municipio.inactive');
Route::put('/municipio/activar','MunicipiosController@activar')->name('municipio.active')->middleware('permission:municipio.active');
Route::get('/municipio/seleccionarMunicipio','MunicipiosController@seleccionar');

Route::get('/empleado','EmpleadosController@index')->name('empleados.index')->middleware('permission:empleado.index');
Route::post('/empleado/registrar','EmpleadosController@store')->name('empleado.store')->middleware('permission:empleado.store');
Route::put('/empleado/actualizar','EmpleadosController@update')->name('empleado.update')->middleware('permission:empleado.update');
Route::put('/empleado/desactivar','EmpleadosController@desactivar')->name('empleado.inactive')->middleware('permission:empleado.inactive');
Route::put('/empleado/activar','EmpleadosController@activar')->name('empleado.active')->middleware('permission:empleado.active');
Route::get('/empleado/seleccionarEmpleado','EmpleadosController@seleccionar');
Route::get('/empleado/colector','EmpleadosController@listaColector');

Route::get('/zona','ZonasController@index')->name('zona.index')->middleware('permission:zona.index');
Route::post('/zona/registrar','ZonasController@store')->name('zona.store')->middleware('permission:zona.store');
Route::put('/zona/actualizar','ZonasController@update')->name('zona.update')->middleware('permission:zona.update');
Route::put('/zona/desactivar','ZonasController@desactivar')->name('zona.inactive')->middleware('permission:zona.inactive');
Route::put('/zona/activar','ZonasController@activar')->name('zona.active')->middleware('permission:zona.active');
Route::get('/zona/seleccionarZona','ZonasController@seleccionar');

Route::get('/barrio','BarriosController@index')->name('barrio.index')->middleware('permission:barrio.index');
Route::post('/barrio/registrar','BarriosController@store')->name('barrio.store')->middleware('permission:barrio.store');
Route::put('/barrio/actualizar','BarriosController@update')->name('barrio.update')->middleware('permission:barrio.update');
Route::get('/barrio/seleccionarBarrio','BarriosController@seleccionar');

Route::get('/cliente','ClientesController@index')->name('cliente.index')->middleware('permission:cliente.index');
Route::post('/cliente/registrar','ClientesController@store')->name('cliente.store')->middleware('permission:cliente.store');
Route::put('/cliente/actualizar','ClientesController@update')->name('cliente.update')->middleware('permission:cliente.update');
Route::get('/cliente/seleccionarCliente','ClientesController@seleccionar');

Route::get('/proyecto','ProyectosController@index')->name('proyecto.index')->middleware('permission:proyecto.index');
Route::post('/proyecto/registrar','ProyectosController@store')->name('proyecto.store')->middleware('permission:proyecto.store');
Route::put('/proyecto/actualizar','ProyectosController@update')->name('proyecto.update')->middleware('permission:proyecto.update');
Route::put('/proyecto/desactivar','ProyectosController@desactivar')->name('proyecto.inactive')->middleware('permission:proyecto.inactive');
Route::put('/proyecto/activar','ProyectosController@activar')->name('proyecto.active')->middleware('permission:proyecto.active');
Route::get('/proyecto/seleccionarProyecto','ProyectosController@seleccionar');

Route::get('/servicio','ServiciosController@index')->name('servicio.index')->middleware('permission:servicio.index');
Route::post('/servicio/registrar','ServiciosController@store')->name('servicio.store')->middleware('permission:servicio.store');
Route::put('/servicio/actualizar','ServiciosController@update')->name('servicio.update')->middleware('permission:servicio.update');
Route::put('/servicio/desactivar','ServiciosController@desactivar')->name('servicio.inactive')->middleware('permission:servicio.inactive');
Route::put('/servicio/activar','ServiciosController@activar')->name('servicio.active')->middleware('permission:servicio.active');
Route::get('/servicio/seleccionarServicio','ServiciosController@seleccionar');
Route::get('/servicio/individual','ServiciosController@ServIndividuales');

Route::get('/acceso','AccesoController@index')->name('acceso.index')->middleware('permission:acceso.index');
Route::post('/acceso/registrar','AccesoController@store')->name('acceso.store')->middleware('permission:acceso.store');
Route::put('/acceso/actualizar','AccesoController@update')->name('acceso.update')->middleware('permission:acceso.update');
Route::put('/acceso/desactivar','AccesoController@desactivar')->name('acceso.inactive')->middleware('permission:acceso.inactive');
Route::put('/acceso/activar','AccesoController@activar')->name('acceso.active')->middleware('permission:acceso.active');

Route::get('/contrato','ContratoController@index')->name('contrato.index')->middleware('permission:contrato.index');
Route::post('/contrato/registrar','ContratoController@store')->name('contrato.store')->middleware('permission:contrato.store');
Route::put('/contrato/actualizar','ContratoController@update')->name('contrato.update')->middleware('permission:contrato.update');
Route::put('/contrato/suspender','ContratoController@suspender')->name('contrato.suspend')->middleware('permission:contrato.suspend');
Route::put('/contrato/activar','ContratoController@activar')->name('contrato.active')->middleware('permission:contrato.active');
Route::get('/contrato/seleccionarContrato','ContratoController@seleccionar');
Route::get('/contrato/informacion','ContratoController@informacion');

Route::get('/factura','FacturasController@index')->name('factura.index')->middleware('permission:factura.index');
Route::post('/factura/registrar','FacturasController@store')->name('factura.store')->middleware('permission:factura.store');
Route::get('/factura/buscar','FacturasController@InfoDocumento');
Route::put('/factura/anular','FacturasController@anular')->name('factura.cancel')->middleware('permission:factura.cancel');
Route::get('/factura/informacion','FacturasController@informacion');

Route::get('/financiamiento','FinanciamientoController@index')->name('financiamiento.index')->middleware('permission:financiamiento.index');
Route::post('/financiamiento/registrar','FinanciamientoController@store')->name('financiamiento.store')->middleware('permission:financiamiento.store');
Route::put('/financiamiento/actualizar','FinanciamientoController@update')->name('financiamiento.update')->middleware('permission:financiamiento.update');
// Route::put('/financiamiento/anular','FinanciamientoController@anular');
Route::get('/financiamiento/informacion','FinanciamientoController@informacion');

Route::get('/tasa','TasaCambiosController@index')->name('tasa.index')->middleware('permission:cambio.index');
Route::get('/tasa/mostrar','TasaCambiosController@mostrar');
Route::post('/tasa/registrar','TasaCambiosController@store')->name('tasa.store')->middleware('permission:cambio.store');
Route::put('/tasa/actualizar','TasaCambiosController@update')->name('tasa.update')->middleware('permission:cambio.update');

Route::get('/ventas','VentasController@index')->name('ventas.index')->middleware('permission:ventas.index');
Route::post('/ventas/registrar','VentasController@store')->name('ventas.store')->middleware('permission:ventas.store');
Route::put('/ventas/anular','VentasController@destroy')->name('ventas.cancel')->middleware('permission:ventas.cancel');
Route::get('/ventas/info','VentasController@informacion');

Route::get('/role','RolesController@index')->name('rol.index')->middleware('permission:rol.index');
Route::post('/role/registrar','RolesController@store')->name('rol.store')->middleware('permission:rol.store');
Route::put('/role/actualizar','RolesController@update')->name('rol.update')->middleware('permission:rol.update');
Route::get('/roles/lista', 'RolesController@listar');
Route::get('/permiso/listar','RolesController@listarpermisos');
Route::get('/permiso/listarAsign','RolesController@permisosAsignado');
Route::get('/permiso/disponible','RolesController@permisosDisponibles');
Route::post('/permiso/registrar','RolesController@permisosRegistrar');
Route::delete('/permiso/eliminar/{id}','RolesController@permisosEliminar');

Route::get('/print/factura/{id}', 'VentasController@ImprimirVenta');
Route::get('/print/estado/{id}', 'InformesController@Estado');
Route::get('/print/recibo/{id}/{documento}', 'FacturasController@ImprimirFactura');
Route::get('/print/calendario/{id}/{fecha1}/{fecha2}', 'InformesController@CalendarioCobro');
Route::get('/print/listadorecibo/{id}/{fecha1}/{fecha2}', 'InformesController@ListadoRecibo');
Route::get('/print/listadorecibotodos/{fecha1}/{fecha2}', 'InformesController@ListadoReciboTodos');
Route::get('/print/listadofacturas/{fecha1}/{fecha2}', 'InformesController@ListadoFactura');

Route::get('/inicio/cobros', 'InformesController@CobroDia');
Route::get('/inicio/cantidadCob', 'InformesController@tcantcobro');
Route::get('/inicio/montocob', 'InformesController@MontoCobrado');
Route::get('/inicio/faltante', 'InformesController@CobroFaltante');
Route::get('/inicio/fecha', 'InformesController@DiaActual');
Route::get('/inicio/estado', 'InformesController@EstadoContrato');
Route::get('/inicio/verificar', 'InformesController@VerificarTasaDia');
Route::get('/dolar/seleccionar', 'InformesController@UltimaTasa');
Route::get('/estadocuenta', 'InformesController@EstadoCuenta');
Route::post('/dolar/registrar','InformesController@storedolar')->name('cambio.store')->middleware('permission:cambio.store');

Route::get('/fecha', 'ContratoController@FechaSistema');


Route::put('/cxc/actfecha', 'CxCController@ActualizarFecha');

});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


