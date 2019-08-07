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

Route::get('scraping','DashboardController@Tasa');

Route::get('/departamento','DepartamentosController@index');
Route::post('/departamento/registrar','DepartamentosController@store');
Route::put('/departamento/actualizar','DepartamentosController@update');
Route::put('/departamento/desactivar','DepartamentosController@desactivar');
Route::put('/departamento/activar','DepartamentosController@activar');
Route::get('/departamento/seleccionarDepartamento','DepartamentosController@seleccionar');

Route::get('/municipio','MunicipiosController@index');
Route::post('/municipio/registrar','MunicipiosController@store');
Route::put('/municipio/actualizar','MunicipiosController@update');
Route::put('/municipio/desactivar','MunicipiosController@desactivar');
Route::put('/municipio/activar','MunicipiosController@activar');
Route::get('/municipio/seleccionarMunicipio','MunicipiosController@seleccionar');

Route::get('/empleado','EmpleadosController@index');
Route::post('/empleado/registrar','EmpleadosController@store');
Route::put('/empleado/actualizar','EmpleadosController@update');
Route::put('/empleado/desactivar','EmpleadosController@desactivar');
Route::put('/empleado/activar','EmpleadosController@activar');
Route::get('/empleado/seleccionarEmpleado','EmpleadosController@seleccionar');

Route::get('/zona','ZonasController@index');
Route::post('/zona/registrar','ZonasController@store');
Route::put('/zona/actualizar','ZonasController@update');
Route::put('/zona/desactivar','ZonasController@desactivar');
Route::put('/zona/activar','ZonasController@activar');
Route::get('/zona/seleccionarZona','ZonasController@seleccionar');

Route::get('/barrio','BarriosController@index');
Route::post('/barrio/registrar','BarriosController@store');
Route::put('/barrio/actualizar','BarriosController@update');
Route::get('/barrio/seleccionarBarrio','BarriosController@seleccionar');

Route::get('/cliente','ClientesController@index');
Route::post('/cliente/registrar','ClientesController@store');
Route::put('/cliente/actualizar','ClientesController@update');
Route::get('/cliente/seleccionarCliente','ClientesController@seleccionar');

Route::get('/proyecto','ProyectosController@index');
Route::post('/proyecto/registrar','ProyectosController@store');
Route::put('/proyecto/actualizar','ProyectosController@update');
Route::put('/proyecto/desactivar','ProyectosController@desactivar');
Route::put('/proyecto/activar','ProyectosController@activar');
Route::get('/proyecto/seleccionarProyecto','ProyectosController@seleccionar');

Route::get('/servicio','ServiciosController@index');
Route::post('/servicio/registrar','ServiciosController@store');
Route::put('/servicio/actualizar','ServiciosController@update');
Route::put('/servicio/desactivar','ServiciosController@desactivar');
Route::put('/servicio/activar','ServiciosController@activar');
Route::get('/servicio/seleccionarServicio','ServiciosController@seleccionar');

Route::get('/acceso','AccesoController@index');
Route::post('/acceso/registrar','AccesoController@store');
Route::put('/acceso/actualizar','AccesoController@update');
Route::put('/acceso/desactivar','AccesoController@desactivar');
Route::put('/acceso/activar','AccesoController@activar');

Route::get('/contrato','ContratoController@index');
Route::post('/contrato/registrar','ContratoController@store');
Route::put('/contrato/actualizar','ContratoController@update');
Route::put('/contrato/suspender','ContratoController@suspender');
Route::put('/contrato/activar','ContratoController@activar');
Route::get('/contrato/seleccionarContrato','ContratoController@seleccionar');

Route::get('/factura','FacturasController@index');
Route::post('/factura/registrar','FacturasController@store');
// Route::put('/factura/actualizar','FacturasController@update');
Route::get('/factura/buscar','FacturasController@InfoDocumento');
Route::put('/factura/anular','FacturasController@anular');

Route::get('/financiamiento','FinanciamientoController@index');
Route::post('/financiamiento/registrar','FinanciamientoController@store');
Route::put('/financiamiento/actualizar','FinanciamientoController@update');
// Route::put('/financiamiento/anular','FinanciamientoController@anular');