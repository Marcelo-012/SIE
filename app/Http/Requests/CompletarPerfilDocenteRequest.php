<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompletarPerfilDocenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha_nacimiento' => 'required|date',
            'curp' => 'required|string|size:18|unique:docentes',
            'genero' => 'required|in:masculino,femenino',
            'estado_civil' => 'required|in:soltero,casado,divorciado,viudo,otro',
            'calle_numero' => 'required|string|max:100',
            'colonia' => 'required|string|max:50',
            'municipio' => 'required|string|max:50',
            'estado' => 'required|string|max:30',
            'codigo_postal' => 'required|string|size:5',
            'telefono' => 'required|string|size:10',
            'correo' => 'required|email|unique:docentes',
            'nivel_estudio' => 'required|string|max:50',
            'antiguedad' => 'required|date',
        ];
    }
}
