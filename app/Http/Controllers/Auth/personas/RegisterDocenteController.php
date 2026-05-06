<?php

namespace App\Http\Controllers\Auth\personas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterDocenteRequest;
use Docente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterDocenteController extends Controller
{
    public function store(RegisterDocenteRequest $request)
    {
        $docente = Docente::create([
            'rfc' => $request->rfc,
            'nombre' => $request->nombre,
            'apellido_pat' => $request->apellido_pat,
            'apellido_mat' => $request->apellido_mat,
            'password' => Hash::make($request->password),
            'perfil_completo' => false,
        ]);

        Auth::guard('docente')->login($docente);

        return redirect()->route('docentes.completar-perfil');
    }
}
