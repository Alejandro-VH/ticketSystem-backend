<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketResponseController;


// Rutas de libres de autenticación
Route::post('login', [UserController::class, 'Login'])->name('iniciar-sesion');
Route::post('register', [UserController::class, 'Register'])->name('registro');

// Rutas protegidas por autenticación y sin roles específicos
Route::middleware('auth:api')->group(function (){
    Route::post('logout', [UserController::class, 'Logout']);

    Route::post('ticket', [TicketController::class, 'CreateTicket']);
    Route::patch('ticket/{id}', [TicketController::class, 'UpdateTicket']);
    Route::post('ticket/{id}/response', [TicketResponseController::class, 'CreateResponse']);
});

// Rutas protegidas por autenticación y exclusivas para administradores y soporte
Route::middleware(['auth:api', 'role:admin,soporte'])->group(function () {
    Route::get('users', [UserController::class, 'GetAllUsers']);
    Route::get('users/{id}', [UserController::class, 'GetUserById']);

    Route::get('tickets', [TicketController::class, 'GetAllTickets']);
    Route::get('tickets/{id}', [TicketController::class, 'GetTicketById']);
    Route::get('tickets/user/{id}', [TicketController::class, 'GetTicketsByUserId']);
    Route::patch('ticket/{id}/priority', [TicketController::class, 'ChangePriority']);
    Route::patch('ticket/{id}/status', [TicketController::class, 'ChangeStatus']);
    Route::patch('ticket/{id}/toggle', [TicketController::class, 'ToggleEnabled']);

});