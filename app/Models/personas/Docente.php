<?php

// app/Models/Docente.php
use Illuminate\Foundation\Auth\User as Authenticatable;

class Docente extends Authenticatable
{
    protected $table = 'docentes';
    protected $primaryKey = 'id_docente';

    protected $fillable = [
        'rfc',
        'nombre',
        'apellido_pat',
        'apellido_mat',
        'password',
        'matricula',
        'curp',
        'genero',
        'estado_civil',
        'telefono',
        'correo',
        'nivel_estudio',
        'antiguedad',
        'status',
        'perfil_completo'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'antiguedad' => 'date',
        'perfil_completo' => 'boolean',
    ];

    // Para login con RFC
    public function getAuthIdentifierName()
    {
        return 'rfc';
    }
}
