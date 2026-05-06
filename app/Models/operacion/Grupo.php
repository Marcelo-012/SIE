<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_grupo';

    protected $fillable = [
        'id_materia',
        'id_docente',
        'id_ciclo_escolar',
        'letra',
        'salon',
        'cupo',
        'cupo_max',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'cupo' => 'integer',
        'cupo_max' => 'integer',
    ];

    // Relaciones
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia', 'id_materia');
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }

    public function cicloEscolar()
    {
        return $this->belongsTo(CicloEscolar::class, 'id_ciclo_escolar', 'id_ciclo_escolar');
    }

    // Scope para grupos activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Verificar si hay cupo disponible
    public function tieneCupo(): bool
    {
        return $this->cupo < $this->cupo_max;
    }
}
