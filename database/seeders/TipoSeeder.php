<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Playa'],
            ['nombre' => 'Montaña'],
            ['nombre' => 'Ciudad'],
            ['nombre' => 'Aventura'],
            ['nombre' => 'Relax'],
            ['nombre' => 'Cultural'],
            ['nombre' => 'Deportivo'],
            ['nombre' => 'Familiar'],
        ];

        foreach ($tipos as $tipo) {
            Tipo::create($tipo);
        }
    }
}