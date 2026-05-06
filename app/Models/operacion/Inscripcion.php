<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';
    protected $primaryKey = 'id_inscripcion';

    protected $fillable = [
        'id_alumno',
        'id_grupo',
        'intento',
        'estatus',
    ];

    protected $casts = [
        'intento' => 'integer',
        'estatus' => 'string',
    ];


    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'id_alumno', 'id_alumno');
    }


    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id_grupo');
    }


    public function calificaciones(): HasMany
    {
        return $this->hasMany(Calificacion::class, 'id_inscripcion', 'id_inscripcion');
    }


    public function scopeCursando($query)
    {
        return $query->where('estatus', 'cursando');
    }


    public function scopeFinalizadas($query)
    {
        return $query->whereIn('estatus', ['aprobado', 'reprobado']);
    }


    public function scopePorAlumno($query, int $idAlumno)
    {
        return $query->where('id_alumno', $idAlumno);
    }


    public function scopePorGrupo($query, int $idGrupo)
    {
        return $query->where('id_grupo', $idGrupo);
    }


    public function estaCursando(): bool
    {
        return $this->estatus === 'cursando';
    }


    public function esPrimerIntento(): bool
    {
        return $this->intento === 1;
    }


    public function puedeReinscribirse(): bool
    {
        return $this->intento < 3 && $this->estatus === 'reprobado';
    }


    public function promedio(): ?float
    {
        $calificaciones = $this->calificaciones;

        if ($calificaciones->isEmpty()) {
            return null;
        }

        return round($calificaciones->avg('calificacion'), 2);
    }


    public function getIntentoOrdinalAttribute(): string
    {
        $ordinales = [1 => '1er', 2 => '2do', 3 => '3er'];
        return $ordinales[$this->intento] ?? "{$this->intento}º";
    }
}
