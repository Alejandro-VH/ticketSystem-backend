<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role IDS
        $userId = Role::where('name', 'Usuario')->first()->id; 
        $supportId = Role::where('name', 'Soporte')->first()->id; 
        $adminId = Role::where('name', 'Administrador')->first()->id; 


        User::create([
            'role_id' => $adminId,
            'name' => 'Administrador',
            'email' => 'admin@ticket.cl',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), 
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        User::create([
            'role_id' => $supportId,
            'name' => 'Felipe',
            'email' => 'soporte@ticket.cl',
            'email_verified_at' => now(),
            'password' => Hash::make('soporte123'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'role_id' => $userId,
            'name' => 'Juan',
            'email' => 'juan@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('cliente123'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
