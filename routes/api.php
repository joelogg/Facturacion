<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('productos/show', 'ApiProductosController@show');
Route::put('productos/edit', 'ApiProductosController@update');
Route::put('productos/create', 'ApiProductosController@create');
Route::delete('productos/destroy', 'ApiProductosController@destroy');


Route::post('facturas/listar', 'ApiFacturaController@listar');
Route::post('facturas/detalles', 'ApiFacturaController@detalles');
Route::put('facturas/crear', 'ApiFacturaController@crear');
Route::delete('facturas/eliminar', 'ApiFacturaController@eliminar');
Route::put('facturas/editar', 'ApiFacturaController@editar');


