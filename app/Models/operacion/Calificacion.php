<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';
    protected $primaryKey = 'id_calificacion';

    protected $fillable = [
        'id_inscripcion',
        'unidad',
        'calificacion',
        'fecha',
        'califiacion_final',
    ];

    protected $casts = [
        'unidad' => 'integer',
        'calificacion' => 'integer',
        'fecha' => 'date',
        'califiacion_final' => 'integer',
    ];


    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(Inscripcion::class, 'id_inscripcion', 'id_inscripcion');
    }


    public function scopePorUnidad($query, int $unidad)
    {
        return $query->where('unidad', $unidad);
    }


    public function scopeAprobadas($query)
    {
        return $query->where('calificacion', '>=', 70);
    }


    public function scopeReprobadas($query)
    {
        return $query->where('calificacion', '<', 70);
    }


    public function esAprobatoria(): bool
    {
        return $this->calificacion >= 70;
    }

    public function getEstadoAttribute(): string
    {
        return $this->esAprobatoria() ? 'Aprobado' : 'Reprobado';
    }
}
