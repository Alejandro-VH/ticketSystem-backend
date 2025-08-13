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
            'user_id' => 3,
            'title' => 'Error en el sistema de facturación',
            'description' => 'Al generar una factura, el sistema arroja un error 500',
            'status' => 'open',
            'priority' => 'high',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Ticket::create([
            'user_id' => 3,
            'title' => 'Solicitud de cambio de contraseña',
            'description' => 'Necesito restablecer mi contraseña porque olvidé la anterior.',
            'status' => 'in_progress',
            'priority' => 'medium',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(1),
        ]);

        Ticket::create([
            'user_id' => 3,
            'title' => 'Problema con acceso a reportes',
            'description' => 'No puedo ver el reporte de ventas del último mes.',
            'status' => 'closed',
            'priority' => 'low',
            'created_at' => now()->subWeek(),
            'updated_at' => now()->subDays(3),
        ]);
    }
}
