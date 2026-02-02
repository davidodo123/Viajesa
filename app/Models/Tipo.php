<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    /**
     * Relación: Un tipo tiene muchas vacaciones
     */
    public function vacaciones()
    {
        return $this->hasMany(Vacacion::class, 'idtipo');
    }
}