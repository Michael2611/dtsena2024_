<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\canalController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\SurcoPlantaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect('/');
});

Route::get('/login', function(){return view('auth.login');});
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registro', function(){return view('auth.registro');});
Route::post('/registro', [AuthController::class, 'registro']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/', function(){
    return view('panel.home');
});

Route::get('/', function(){
    return view('panel.home');
});

Route::match(['get', 'post'], '/registro-valores', [CanalController::class, 'registroDatos']);

Route::get('/', [homeController::class, 'canales']);
Route::get('/mis-canales/{id}', [canalController::class, 'mis_canales']);
Route::get('/mis-canales/canal/{id}', [canalController::class, 'canal']);
Route::get('/panel/mis-canales/canal/{id}/datos', [canalController::class, 'getDatos'])->name('canal.datos');

Route::get('/panel/mis-canales/canal/{id}/dispositivos/{idDispositivo}', [canalController::class, 'canal'])->where('idDispositivo', '[0-9]+');

Route::get('/panel/mis-canales/canal/{id}/datospromedio', [canalController::class, 'getDatosPromedio'])->name('canal.datospromedio');


//nuevas rutas
Route::get('/canal/{id}/configuracion-canal', [canalController::class, 'configuracion_canal'])->name('configuracion_canal');
Route::get('/canal/{id}/dispositivos', [canalController::class, 'vista_dispositivos'])->name('vista_dispositivo');
Route::get('/canal/{id}/vista-publica', [canalController::class, 'vista_publica'])->name('vista_publica');
Route::get('/canal/{id}/compartir', [canalController::class, 'compartir'])->name('compartir');
Route::get('/canal/{id}/credenciales', [canalController::class, 'credenciales'])->name('credenciales');
Route::get('/canal/{id}/distribucion-terreno', [canalController::class, 'distribucion_terreno'])->name('distribucion_terreno');


Route::post('/generar-tabla-cultivo', [SurcoPlantaController::class, 'generarTablaCultivo'])->name('generar-tabla');
Route::get('/generar-tabla-cultivo', [SurcoPlantaController::class, 'actualizarTablaCultivo'])->name('actualizar-tabla');

Route::post('/registro-canal', [canalController::class, 'store']);
Route::put('/actualizar-canal/{id}', [canalController::class, 'updateCanal']);
Route::delete('/panel/canal/{id}', [canalController::class, 'eliminarCanal']);
Route::post('/panel/mis-canales/registro-dispositivo', [canalController::class, 'add_dispositivo']);
Route::put('/panel/mis-canales/actualizar-dispositivo/{id}/{icanal}', [canalController::class, 'updateDispositivo']);
Route::delete('/panel/mis-canales/eliminar-dispositivo/{id}', [canalController::class, 'deleteDispositivo']);

//Rutas de exportar datos
Route::get('/exportar-datos-canal/{id}', [canalController::class, 'exportarExcelDatos']);


Route::get('/panel/canal/{id}', [canalController::class, 'edit']);



