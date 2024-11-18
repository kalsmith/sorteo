<?php

use App\Http\Controllers\TiendaController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});


Route::middleware('auth')->group(function () {
    Route::resource('tiendas', TiendaController::class);
    Route::resource('ventas', VentaController::class);
    Route::get('sorteo', [VentaController::class, 'sorteo'])->name('sorteo');
    Route::post('sorteo', [VentaController::class, 'sorteoNumero'])->name('sorteoNumero');
    Route::post('sendMail', [VentaController::class, 'sendMail'])->name('sendMail');

    // Route::post('ventas/{tienda}', [VentaController::class, 'store'])->name('ventas.store');
});



Route::middleware([ 'auth:sanctum', config('jetstream.auth_session'),'verified',])->group(function () {
Route::get('/dashboard', function () { return view('dashboard');})->name('dashboard');

});
