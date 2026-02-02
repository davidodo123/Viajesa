<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $fillable = ['idvacacion', 'ruta'];

    /**
     * Relación: Una foto pertenece a una vacación
     */
    public function vacacion()
    {
        return $this->belongsTo(Vacacion::class, 'idvacacion');
    }
}