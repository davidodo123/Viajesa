<?php

namespace Database\Seeders;

use App\Models\Vacacion;
use Illuminate\Database\Seeder;

class VacacionSeeder extends Seeder
{
    public function run(): void
    {
        $vacaciones = [
            [
                'titulo' => 'Caribe Paraíso - Cancún',
                'descripcion' => 'Disfruta de 7 días en las mejores playas del Caribe mexicano con todo incluido.',
                'precio' => 1299.99,
                'pais' => 'México',
                'idtipo' => 1
            ],
            [
                'titulo' => 'Aventura Alpina - Suiza',
                'descripcion' => 'Escapada de 5 días a los Alpes suizos con actividades de esquí y senderismo.',
                'precio' => 1899.50,
                'pais' => 'Suiza',
                'idtipo' => 2
            ],
            [
                'titulo' => 'Roma Histórica',
                'descripcion' => 'Tour cultural de 6 días por la ciudad eterna con guía incluido.',
                'precio' => 999.00,
                'pais' => 'Italia',
                'idtipo' => 6
            ],
            [
                'titulo' => 'Safari en Kenia',
                'descripcion' => 'Experiencia única de 10 días en los parques nacionales de Kenia.',
                'precio' => 2499.99,
                'pais' => 'Kenia',
                'idtipo' => 4
            ],
            [
                'titulo' => 'Maldivas Relax Resort',
                'descripcion' => 'Desconexión total en un resort de lujo en las Maldivas durante 8 días.',
                'precio' => 3200.00,
                'pais' => 'Maldivas',
                'idtipo' => 5
            ],
            [
                'titulo' => 'Nueva York Express',
                'descripcion' => 'Escapada de 4 días a la Gran Manzana con tours incluidos.',
                'precio' => 1150.00,
                'pais' => 'Estados Unidos',
                'idtipo' => 3
            ],
        ];

        foreach ($vacaciones as $vacacion) {
            Vacacion::create($vacacion);
        }
    }
}