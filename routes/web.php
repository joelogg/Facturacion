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


//----------- Sesion ---------
Route::get('/', 'SesionController@index');
Route::post('login', 'SesionController@login');

//----------- Productos ---------  
Route::get('/productos', 'ProductosController@index')
    ->name('productos');

//----------- Factura ---------  
Route::get('/factura', 'FacturaController@index');
Route::post('/factura', 'FacturaController@index');

Route::get('/factura/listaFinalizada', 'FacturaController@listaFinalizadas');
Route::get('/factura/listaAvance', 'FacturaController@listaAvances');

//----------- Guia Remision ---------  
Route::get('/guia_remision', 'GuiaRemisionController@index');
