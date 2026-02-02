<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacacion extends Model
{
    use HasFactory;

    protected $table = 'vacaciones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'precio',
        'pais',
        'idtipo'
    ];

    /**
     * Relación: Una vacación pertenece a un tipo
     */
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'idtipo');
    }

    /**
     * Relación: Una vacación tiene muchas fotos
     */
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'idvacacion');
    }

    /**
     * Relación: Una vacación tiene muchas reservas
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'idvacacion');
    }

    /**
     * Relación: Una vacación tiene muchos comentarios
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'idvacacion');
    }

    /**
     * Relación: Usuarios que han reservado esta vacación
     */
    public function usuariosReservados()
    {
        return $this->belongsToMany(User::class, 'reservas', 'idvacacion', 'iduser')->withTimestamps();
    }
}