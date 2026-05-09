<?php

namespace App\Models\personas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Alumno extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'alumnos';

    // "matricula" es el identificador único con el que el alumno inicia sesión.
    // Auth::id() devolverá '22730346' (string) y sessions.user_id lo almacena correctamente.
    protected $primaryKey = 'matricula';
    public    $incrementing = false;      // no es auto-increment
    protected $keyType     = 'string';   // indica a Eloquent que el PK es texto

    protected $fillable = [
        'matricula',
        'nombre',
        'apellido_pat',
        'apellido_mat',
        'fecha_nacimiento',
        'curp',
        'genero',
        'estado_civil',
        'calle_y_numero',
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
        'password'         => 'hashed',
    ];

    // getAuthIdentifierName() ya no es necesario sobreescribirlo:
    // hereda de Authenticatable -> getKeyName() -> 'matricula'
    // getAuthIdentifier() -> $this->matricula -> '22730346' (string)

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
}
