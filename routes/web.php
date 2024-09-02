<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/instalar', function(){
    return view('instalar');
});
Route::group(['middleware' => 'auth'], function () {

  Route::group(['middleware' => 'admin'], function () {
    Route::resource('usuarios', 'UsuarioController');
    Route::resource('estaciones', 'EstacionController');
    Route::resource('cuentacorriente', 'CuentaCorrienteController');

    Route::get('cuentacorriente/transferir/{id}', 'CuentaCorrienteController@transferir');
    Route::get('cuentacorriente/iniciar/{id}', 'CuentaCorrienteController@iniciar');
    Route::get('cuentacorriente/depositar/{id}', 'CuentaCorrienteController@depositar');
    Route::get('cuentacorriente/extraer/{id}', 'CuentaCorrienteController@extraer');
  });

  Route::group(['middleware' => 'visor_cuentas'], function () {
    Route::resource('cuentacorriente', 'CuentaCorrienteController');
    Route::resource('reportes', 'ReporteController');
  });

  Route::group(['middleware' => ['expendedor']], function () {
    Route::resource('consumo', 'ConsumoController');
    Route::get('consumo/ingresar/{id}', 'ConsumoController@ingresar');
    Route::post('consumo/validar/{id}', 'ConsumoController@validar');
    Route::get('consumo/verificarusuario/{id}/{monto}', 'ConsumoController@verificarusuario');
    Route::post('consumo/grabar/{id}/{monto}', 'ConsumoController@grabar');
    Route::get('expendedor/reportes','ReporteController@porExpendedor');
  });

  Route::get('micuenta/{id}', 'CuentaCorrienteController@show');

//  Route::post('expendedor/reportes','ReporteController@porExpendedor');
  Route::get('cambiarclave', 'UsuarioController@cambiarclave');
  Route::post('cambiarclave', 'UsuarioController@grabarcambiarclave');
});
