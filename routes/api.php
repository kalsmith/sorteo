<?php

use App\Http\Controllers\ApiTiendaController;
use App\Http\Controllers\ApiVentaController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    return response()->json([
        'token' => $user->createToken($request->device_name)->plainTextToken,
        'message' => 'Success'
      ]);

});



Route::middleware('auth:sanctum')->group(function () {
    Route::resource('tiendas', ApiTiendaController::class)->only(['index','store','update']);
    Route::resource('ventas', ApiVentaController::class)->only(['store', 'index']);
    
});

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logged out successfully']);
});
