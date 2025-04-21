<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;

// Rutas de autenticación
Route::prefix('')->group(function () {
    Route::get('GetAllUsers', [UserController::class, 'GetAllUsers'])->name('usuarios');
    Route::post('Login', [UserController::class, 'Login'])->name('Login');
});

// Rutas protegidas
Route::middleware('auth:api')->group(function (){

});