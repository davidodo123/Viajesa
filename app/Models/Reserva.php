<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = ['iduser', 'idvacacion'];

    /**
     * Relación: Una reserva pertenece a un usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'iduser');
    }

    /**
     * Relación: Una reserva pertenece a una vacación
     */
    public function vacacion()
    {
        return $this->belongsTo(Vacacion::class, 'idvacacion');
    }
}