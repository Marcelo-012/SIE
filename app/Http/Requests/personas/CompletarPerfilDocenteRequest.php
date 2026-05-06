<?php

namespace App\Http\Requests\personas;

use Illuminate\Foundation\Http\FormRequest;

class CompletarPerfilDocenteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'matricula' => 'required|string|unique:docentes',
            'curp' => 'required|string|size:18|unique:docentes',
            'genero' => 'required|in:masculino,femenino',
            'estado_civil' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'required|email|unique:docentes',
            'nivel_estudio' => 'required|string',
            'antiguedad' => 'required|date',
        ];
    }
}
