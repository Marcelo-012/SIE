<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';
    protected $primaryKey = 'id_materia';

    protected $fillable = [
        'clave_materia',
        'nombre_materia',
        'unidades',
        'creditos',
        'plan_estudios',
        'departamento',
        'idioma',
        'objetivo',
        'caracterizacion',
        'intencion_didactica',
        'bibliografia',
    ];

    protected $casts = [
        'unidades' => 'integer',
        'creditos' => 'integer',
    ];

    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_materia', 'id_materia');
    }

    public function unidadesTemario()
    {
        return $this->hasMany(UnidadTemario::class, 'id_materia', 'id_materia')->orderBy('numero');
    }
}
