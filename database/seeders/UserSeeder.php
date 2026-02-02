<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@viajes.com',
            'password' => Hash::make('12345678'),
            'rol' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Advanced
        User::create([
            'name' => 'Usuario Avanzado',
            'email' => 'advanced@viajes.com',
            'password' => Hash::make('12345678'),
            'rol' => 'advanced',
            'email_verified_at' => now(),
        ]);

        // Users normales
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('12345678'),
            'rol' => 'user',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'María García',
            'email' => 'maria@gmail.com',
            'password' => Hash::make('12345678'),
            'rol' => 'user',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Carlos López',
            'email' => 'carlos@gmail.com',
            'password' => Hash::make('12345678'),
            'rol' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}