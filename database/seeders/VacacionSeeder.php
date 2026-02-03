<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VacacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        \App\Models\Vacacion::create([
            'titulo' => 'Aventura en los Pirineos',
            'descripcion' => 'Senderismo y deportes de riesgo en alta montaña.',
            'precio' => 450.00,
            'pais' => 'España',
            'idtipo' => 1
        ]);

        \App\Models\Vacacion::create([
            'titulo' => 'Escapada a París',
            'descripcion' => 'Descubre la ciudad del amor: Torre Eiffel, Louvre y gastronomía francesa.',
            'precio' => 680.00,
            'pais' => 'Francia',
            'idtipo' => 2
        ]);

        \App\Models\Vacacion::create([
            'titulo' => 'Playas de Cancún',
            'descripcion' => 'Resort todo incluido con acceso a playas paradisíacas y ruinas mayas.',
            'precio' => 1200.00,
            'pais' => 'México',
            'idtipo' => 3
        ]);

        \App\Models\Vacacion::create([
            'titulo' => 'Safari en Kenia',
            'descripcion' => 'Explora la sabana africana y observa los Big Five en su hábitat natural.',
            'precio' => 2500.00,
            'pais' => 'Kenia',
            'idtipo' => 1
        ]);

        \App\Models\Vacacion::create([
            'titulo' => 'Ruta por Japón',
            'descripcion' => 'Tokio, Kioto y Osaka: templos, tecnología y cultura milenaria.',
            'precio' => 1800.00,
            'pais' => 'Japón',
            'idtipo' => 2
        ]);

        \App\Models\Vacacion::create([
            'titulo' => 'Crucero por el Mediterráneo',
            'descripcion' => 'Visita Italia, Grecia y Croacia en un lujoso crucero de 7 días.',
            'precio' => 1500.00,
            'pais' => 'Italia',
            'idtipo' => 4
        ]);

        \App\Models\Vacacion::create([
            'titulo' => 'Relax en Maldivas',
            'descripcion' => 'Bungalows sobre el agua cristalina y spa de lujo.',
            'precio' => 3200.00,
            'pais' => 'Maldivas',
            'idtipo' => 3
        ]);

        \App\Models\Vacacion::create([
            'titulo' => 'Nueva York Express',
            'descripcion' => 'Times Square, Central Park, Estatua de la Libertad y Broadway.',
            'precio' => 950.00,
            'pais' => 'Estados Unidos',
            'idtipo' => 2
        ]);

        \App\Models\Vacacion::create([
            'titulo' => 'Trekking en Machu Picchu',
            'descripcion' => 'Camino Inca de 4 días hasta la ciudadela perdida de los Incas.',
            'precio' => 1100.00,
            'pais' => 'Perú',
            'idtipo' => 1
        ]);

        \App\Models\Vacacion::create([
            'titulo' => 'Auroras Boreales en Islandia',
            'descripcion' => 'Geysers, cascadas y el espectáculo de las luces del norte.',
            'precio' => 1350.00,
            'pais' => 'Islandia',
            'idtipo' => 1
        ]);
    }
}
