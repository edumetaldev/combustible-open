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
Route::get('/home',[App\Http\Controllers\HomeController::class,'index'])->name('home');
Route::get('/instalar', function(){
    return view('instalar');
});
Route::group(['middleware' => 'auth'], function () {

  Route::group(['middleware' => 'admin'], function () {
    Route::resource('usuarios', App\Http\Controllers\UsuarioController::class);
    Route::resource('estaciones', App\Http\Controllers\EstacionController::class);
    Route::resource('cuentacorriente', App\Http\Controllers\CuentaCorrienteController::class);

    Route::get('cuentacorriente/transferir/{id}', [App\Http\Controllers\CuentaCorrienteController::class,'transferir']);
    Route::get('cuentacorriente/iniciar/{id}', [App\Http\Controllers\CuentaCorrienteController::class,'iniciar']);
    Route::get('cuentacorriente/depositar/{id}', [App\Http\Controllers\CuentaCorrienteController::class,'depositar']);
    Route::get('cuentacorriente/extraer/{id}', [App\Http\Controllers\CuentaCorrienteController::class,'extraer']);
  });

  Route::group(['middleware' => 'visor_cuentas'], function () {
    Route::resource('cuentacorriente', App\Http\Controllers\CuentaCorrienteController::class);
    Route::resource('reportes', App\Http\Controllers\ReporteController::class);
  });

  Route::group(['middleware' => ['expendedor']], function () {
    Route::resource('consumo', App\Http\Controllers\ConsumoController::class);
    Route::get('consumo/ingresar/{id}', [App\Http\Controllers\ConsumoController::class,'ingresar']);
    Route::post('consumo/validar/{id}', [App\Http\Controllers\ConsumoController::class,'validar']);
    Route::get('consumo/verificarusuario/{id}/{monto}', [App\Http\Controllers\ConsumoController::class,'verificarusuario']);
    Route::post('consumo/grabar/{id}/{monto}', [App\Http\Controllers\ConsumoController::class,'grabar']);
    Route::get('expendedor/reportes',[App\Http\Controllers\ReporteController::class,'porExpendedor']);
  });

  Route::get('micuenta/{id}', [App\Http\Controllers\CuentaCorrienteController::class,'show']);

//  Route::post([App\Http\Controllers\expendedor/reportes','ReporteController::class,'porExpendedor']);
  Route::get('cambiarclave', [App\Http\Controllers\UsuarioController::class,'cambiarclave']);
  Route::post('cambiarclave', [App\Http\Controllers\UsuarioController::class,'grabarcambiarclave']);
});
