<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = ['iduser', 'idvacacion', 'texto'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'iduser');
    }

    public function vacacion()
    {
        return $this->belongsTo(Vacacion::class, 'idvacacion');
    }
}