<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketResponseController;


// Rutas de libres de autenticación
Route::post('login', [UserController::class, 'Login'])->name('iniciar-sesion');
Route::post('register', [UserController::class, 'Register'])->name('registro');

// Rutas protegidas
Route::middleware('auth:api')->group(function (){
    // Users
    Route::post('logout', [UserController::class, 'Logout']);
    Route::get('users', [UserController::class, 'GetAllUsers']);
    Route::get('users/{id}', [UserController::class, 'GetUserById']);

    // Tickets
    Route::post('ticket', [TicketController::class, 'CreateTicket']);
    Route::patch('ticket/{id}', [TicketController::class, 'UpdateTicket']);
    Route::patch('ticket/{id}/priority', [TicketController::class, 'ChangePriority']);
    Route::patch('ticket/{id}/status', [TicketController::class, 'ChangeStatus']);
    Route::patch('ticket/{id}/toggle', [TicketController::class, 'ToggleEnabled']);

    Route::get('tickets', [TicketController::class, 'GetAllTickets']);
    Route::get('tickets/{id}', [TicketController::class, 'GetTicketById']);
    Route::get('tickets/user/{id}', [TicketController::class, 'GetTicketsByUserId']);

    // Ticket Response
    Route::post('ticket/{id}/response', [TicketResponseController::class, 'CreateResponse']);
});