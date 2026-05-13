<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';
    protected $primaryKey = 'id_tarea';

    protected $fillable = [
        'id_grupo',
        'numero_unidad',
        'titulo',
        'descripcion',
        'fecha_entrega',
    ];

    protected $casts = [
        'numero_unidad' => 'integer',
        'fecha_entrega' => 'date',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id_grupo');
    }
}
