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

    Route::post('tickets', [TicketController::class, 'CreateTicket']);
    Route::get('my-tickets', [TicketController::class, 'GetMyTickets']);
    Route::get('tickets/my/{id}', [TicketController::class, 'GetMyTicketById']);
    Route::patch('tickets/{id}', [TicketController::class, 'UpdateTicket']);
    Route::post('tickets/{id}/responses', [TicketResponseController::class, 'CreateResponse']);
    Route::get('tickets/{id}/responses', [TicketResponseController::class, 'getResponse']);
});

// Rutas protegidas por autenticación y exclusivas para administradores y soporte
Route::middleware(['auth:api', 'role:Administrador,Soporte'])->group(function () {
    Route::get('users', [UserController::class, 'GetAllUsers']);
    Route::get('users/{id}', [UserController::class, 'GetUserById']);
    Route::get('users/stats', [UserController::class, 'GetUserStats']);
    
    Route::get('tickets', [TicketController::class, 'GetAllTickets']);
    Route::get('tickets/{id}', [TicketController::class, 'GetTicketById']);
    Route::get('users/{id}/tickets', [TicketController::class, 'GetTicketsByUserId']);
    Route::get('/tickets/stats', [TicketController::class, 'getTicketStats']);
    Route::patch('tickets/{id}/priority', [TicketController::class, 'ChangePriority']);
    Route::patch('tickets/{id}/status', [TicketController::class, 'ChangeStatus']);
    Route::patch('tickets/{id}/toggle', [TicketController::class, 'ToggleEnabled']);

});