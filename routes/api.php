<?php

use App\Http\Controllers\ApiTiendaController;
use App\Http\Controllers\ApiVentaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::resource('tiendas', ApiTiendaController::class);
Route::resource('ventas', ApiVentaController::class);

