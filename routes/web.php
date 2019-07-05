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
Route::put('/barrio/desactivar','BarriosController@desactivar');
Route::put('/barrio/activar','BarriosController@activar');
Route::get('/barrio/seleccionarBarrio','BarriosController@seleccionar');