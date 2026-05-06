<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Alumno extends Authenticatable
{
    use HasFactory;

    protected $table = 'alumnos';
    protected $primaryKey = 'id_alumno';
    public $timestamps = false; // ajusta según tu tabla

    protected $fillable = [
        'matricula',
        'nombre',
        'apellido_pat',
        'apellido_mat',
        'fecha_nacimiento',
        'curp',
        'genero',
        'estado_civil',
        'calle_numero', // corregido
        'colonia',
        'municipio',
        'estado',
        'codigo_postal',
        'telefono',
        'correo',
        'carrera',
        'especialidad',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'password' => 'hashed',
    ];

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido_pat} {$this->apellido_mat}";
    }

    protected function curp(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            set: fn(string $value) => strtoupper($value),
        );
    }

    public function scopeActivos($query)
    {
        return $query->where('status', 'activo');
    }

    public function scopePorMatricula($query, string $matricula)
    {
        return $query->where('matricula', $matricula);
    }
}
