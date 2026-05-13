<?php

namespace App\Models;

use App\Models\personas\Docente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';
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
        'activo'    => 'boolean',
        'cupo'      => 'integer',
        'cupo_max'  => 'integer',
    ];

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

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_grupo', 'id_grupo');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_grupo', 'id_grupo');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function tieneCupo(): bool
    {
        return $this->cupo < $this->cupo_max;
    }
}
