<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vacacion extends Model
{
    use HasFactory;

    protected $table = 'vacacion';

    protected $fillable = [
        'titulo', 'descripcion', 'precio', 'pais', 'idtipo',
    ];

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class, 'idtipo');
    }

    public function foto(): HasOne
    {
        return $this->hasOne(Foto::class, 'idvacation');
    }

    public function comentario(): HasMany
    {
        return $this->hasMany(Comentario::class, 'idvacation');
    }

    public function reserva(): HasOne
    {
        return $this->hasOne(Reserva::class, 'idvacation');
    }
}