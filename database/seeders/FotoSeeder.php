<?php

namespace Database\Seeders;

use App\Models\Foto;
use Illuminate\Database\Seeder;

class FotoSeeder extends Seeder
{
    public function run(): void
    {
        $fotos = [
            ['idvacacion' => 1, 'ruta' => 'https://picsum.photos/800/600?random=1'],
            ['idvacacion' => 1, 'ruta' => 'https://picsum.photos/800/600?random=2'],
            ['idvacacion' => 2, 'ruta' => 'https://picsum.photos/800/600?random=3'],
            ['idvacacion' => 2, 'ruta' => 'https://picsum.photos/800/600?random=4'],
            ['idvacacion' => 3, 'ruta' => 'https://picsum.photos/800/600?random=5'],
            ['idvacacion' => 4, 'ruta' => 'https://picsum.photos/800/600?random=6'],
            ['idvacacion' => 5, 'ruta' => 'https://picsum.photos/800/600?random=7'],
            ['idvacacion' => 6, 'ruta' => 'https://picsum.photos/800/600?random=8'],
        ];

        foreach ($fotos as $foto) {
            Foto::create($foto);
        }
    }
}