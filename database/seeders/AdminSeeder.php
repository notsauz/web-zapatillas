<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o actualizar usuario admin
        User::updateOrCreate(
            ['email' => 'infotopsneakerses@gmail.com'],
            [
                'name' => 'admin',
                'username' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('tfghugo1'), // Contraseña segura para el admin
                'is_admin' => true,
            ]
        );
    }
}
