<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadTemario extends Model
{
    use HasFactory;

    protected $table = 'unidades_temario';
    protected $primaryKey = 'id_unidad';

    protected $fillable = [
        'id_materia',
        'numero',
        'titulo',
        'descripcion',
    ];

    protected $casts = [
        'numero' => 'integer',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia', 'id_materia');
    }
}
