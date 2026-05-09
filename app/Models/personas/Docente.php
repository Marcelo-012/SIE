<?php

namespace App\Models\personas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Docente extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'docentes';

    // "usuario" es la llave de negocio única con la que el docente inicia sesión.
    // Al declararla como primaryKey, Auth::id() devuelve el string 'edgar.garcia'
    // y sessions.user_id (ahora varchar) lo almacena correctamente.
    protected $primaryKey = 'usuario';
    public    $incrementing = false;      // no es auto-increment
    protected $keyType     = 'string';   // indica a Eloquent que el PK es texto

    protected $fillable = [
        'rfc',
        'usuario',
        'nombre',
        'apellido_pat',
        'apellido_mat',
        'password',
        'fecha_nacimiento',
        'curp',
        'genero',
        'estado_civil',
        'calle_numero',
        'colonia',
        'municipio',
        'estado',
        'codigo_postal',
        'telefono',
        'correo',
        'nivel_estudio',
        'antiguedad',
        'status',
        'perfil_completo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'antiguedad'      => 'date',
        'perfil_completo' => 'boolean',
        'password'        => 'hashed',
    ];

    // getAuthIdentifierName() ya no es necesario sobreescribirlo:
    // hereda de Authenticatable -> getKeyName() -> 'usuario'
    // getAuthIdentifier() -> $this->usuario -> 'edgar.garcia' (string)
}
