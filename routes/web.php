<?php

use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::view('Gestion', 'reporte.index')->middleware('can:gestion')->name('gestion');
    Route::view('Area', 'area.index')->middleware('can:area')->name('area');
    Route::view('Impacto', 'impacto.index')->middleware('can:impacto')->name('impacto');
    Route::view('Gestion-Areas', 'panal.index')->middleware('can:panal')->name('panal');
    Route::view('Jefes-Areas', 'gestion.index')->middleware('can:panal')->name('jefes');
    Route::view('Reportador', 'reportador.index')->middleware('can:reportador')->name('reportador');
    Route::view('Usuarios', 'usuario.usuario')->middleware('can:usuarios')->name('usuarios');
});
Route::view('Consulta', 'consultar')->name('consultar');
Route::view('Reporte', 'reporte')->name('reporte');
