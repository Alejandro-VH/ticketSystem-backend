<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::create([
            'user_id' => 2, // Usuario Ejemplo
            'title' => 'Problema con el login',
            'description' => 'No puedo iniciar sesión con mis credenciales.',
            'status' => 'open',
            'priority' => 'high',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
