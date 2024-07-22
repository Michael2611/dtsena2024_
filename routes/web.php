<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\canalController;
use App\Http\Controllers\homeController;
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
    return redirect('/panel');
});

Route::get('/login', function(){return view('auth.login');});
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registro', function(){return view('auth.registro');});
Route::post('/registro', [AuthController::class, 'registro']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/panel', function(){
    return view('panel.home');
});

Route::get('/panel', function(){
    return view('panel.home');
});

Route::match(['get', 'post'], '/registro-valores', [CanalController::class, 'registroDatos']);

Route::get('/panel', [homeController::class, 'canales']);
Route::get('/panel/mis-canales/{id}', [canalController::class, 'mis_canales']);
Route::get('/panel/mis-canales/canal/{id}', [canalController::class, 'canal']);
Route::get('/panel/mis-canales/canal/{id}/datos', [canalController::class, 'getDatos'])->name('canal.datos');
Route::get('/panel/mis-canales/canal/{id}/dispositivo/{idDispositivo}', [canalController::class, 'canal'])->where('idDispositivo', '[0-9]+');

Route::get('/panel/mis-canales/canal/{id}/datospromedio', [canalController::class, 'getDatosPromedio'])->name('canal.datospromedio');

Route::post('/registro-canal', [canalController::class, 'store']);
Route::put('/actualizar-canal/{id}', [canalController::class, 'updateCanal']);
Route::delete('/panel/canal/{id}', [canalController::class, 'eliminarCanal']);
Route::post('/panel/mis-canales/registro-dispositivo', [canalController::class, 'add_dispositivo']);
Route::put('/panel/mis-canales/actualizar-dispositivo/{id}/{icanal}', [canalController::class, 'updateDispositivo']);
Route::delete('/panel/mis-canales/eliminar-dispositivo/{id}', [canalController::class, 'deleteDispositivo']);





Route::get('/panel/canal/{id}', [canalController::class, 'edit']);



