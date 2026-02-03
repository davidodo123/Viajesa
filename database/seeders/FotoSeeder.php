<?php

namespace Database\Seeders;

use App\Models\Foto;
use Illuminate\Database\Seeder;

class FotoSeeder extends Seeder
{
    public function run(): void
    {
        $fotos = [
            ['idvacation' => 1, 'path' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800'],
            ['idvacation' => 2, 'path' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800'],
            ['idvacation' => 3, 'path' => 'https://images.unsplash.com/photo-1510097467424-192d713fd8b2?w=800'],
            ['idvacation' => 4, 'path' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=800'],
            ['idvacation' => 5, 'path' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=800'],
            ['idvacation' => 6, 'path' => 'https://images.unsplash.com/photo-1548574505-5e239809ee19?w=800'],
            ['idvacation' => 7, 'path' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=800'],
            ['idvacation' => 8, 'path' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=800'],
            ['idvacation' => 9, 'path' => 'https://images.unsplash.com/photo-1587595431973-160d0d94add1?w=800'],
            ['idvacation' => 10, 'path' => 'https://images.unsplash.com/photo-1531168556467-80aace0d0144?w=800'],
        ];

        foreach ($fotos as $foto) {
            Foto::create($foto);
        }
    }
}
