<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterDocenteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rfc' => 'required|string|size:13|unique:docentes',
            'nombre' => 'required|string|max:255',
            'apellido_pat' => 'required|string|max:255',
            'apellido_mat' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
