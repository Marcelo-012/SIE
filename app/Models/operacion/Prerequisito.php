<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MateriaPrerequisito extends Model
{
    use HasFactory;

    protected $table = 'materia_prerequisito';

    // Desactivar timestamps si no los necesitas (opcional)
    // public $timestamps = false;

    protected $fillable = [
        'materia_id',
        'prerequisito_id',
    ];

    protected $casts = [
        'materia_id' => 'integer',
        'prerequisito_id' => 'integer',
    ];


    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id', 'id_materia');
    }


    public function prerequisito(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'prerequisito_id', 'id_materia');
    }


    public function scopePrerequisitosDe($query, int $materiaId)
    {
        return $query->where('materia_id', $materiaId);
    }


    public function scopeMateriasQueRequieren($query, int $prerequisitoId)
    {
        return $query->where('prerequisito_id', $prerequisitoId);
    }
}
