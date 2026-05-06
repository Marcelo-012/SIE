<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_horario';

    protected $fillable = [
        'id_grupo',
        'dia_semana',
        'hora_inicio',
        'hora_final',
        'salon',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_final' => 'datetime:H:i',
    ];

    // Relación
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id_grupo');
    }

    // Scope por día
    public function scopePorDia($query, string $dia)
    {
        return $query->where('dia_semana', $dia);
    }

    // Validar horario lógico
    public function esValido(): bool
    {
        return $this->hora_inicio < $this->hora_final;
    }

    // Accessor para formato legible
    public function getRangoHorarioAttribute(): string
    {
        return "{$this->hora_inicio->format('H:i')} - {$this->hora_final->format('H:i')}";
    }
}
