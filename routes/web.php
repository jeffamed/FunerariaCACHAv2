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
Route::post('/departamento/registrar','DepartamentoControsller@store');
Route::put('/departamento/actualizar','DepartamentoControsller@update');
Route::put('/departamento/desactivar','DepartamentoControsller@desactivar');
Route::put('/departamento/activar','DepartamentosController@activar');
