<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

    Route::get('/clientes',[ClienteController::class,'clientes']);
    Route::post('/crear-clientes',[ClienteController::class,'crearClientes']);
    Route::post('/eliminar-clientes/{id}',[ClienteController::class,'eliminarClientes']);
