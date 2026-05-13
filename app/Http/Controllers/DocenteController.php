<?php

namespace App\Http\Controllers;

use App\Http\Requests\personas\CompletarPerfilDocenteRequest;
use App\Http\Requests\UpdateDocenteRequest;
use App\Models\personas\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DocenteController extends Controller
{
    /**
     * Mostrar formulario para completar perfil
     */
    public function mostrarCompletarPerfil()
    {
        if (Auth::guard('docente')->user()->perfil_completo) {
            return redirect()->route('dashboard');
        }
        return view('docentes.completar-perfil');
    }

    /**
     * Guardar datos del perfil completado
     */
    public function completarPerfil(CompletarPerfilDocenteRequest $request)
    {
        /** @var Docente $docente */
        $docente = Auth::guard('docente')->user();

        $docente->update(array_merge(
            $request->validated(),
            [
                'perfil_completo' => true,
                'status' => 'activo',
            ]
        ));
        // ... rest of code
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docentes = Docente::all();
        return view('docentes.index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('docentes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Este método lo usarás después si necesitas crear docentes desde admin
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $usuario = Docente::with(['centroTrabajo', 'plazas', 'nombramiento'])
            ->findOrFail(auth('docente')->id());

        return view('docentes.perfil.informacion-personal', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Docente $docente)
    {
        return view('docentes.edit', compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocenteRequest $request, Docente $docente)
    {
        $docente->update($request->validated());

        return redirect()->route('docentes.index')
            ->with('success', 'Docente actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        $docente->delete();

        return redirect()->route('docentes.index')
            ->with('success', 'Docente eliminado exitosamente');
    }

    public function mostrarCambiarContrasena()
    {
        return redirect()->route('docente.dashboard')->with('activeTab', 'opciones');
    }

    public function cambiarContrasena(Request $request)
    {
        $request->validate([
            'password_actual'             => ['required'],
            'password_nueva'              => ['required', 'min:8', 'regex:/[0-9]/', 'regex:/[^A-Za-z0-9]/', 'confirmed'],
            'password_nueva_confirmation' => ['required'],
        ], [
            'password_nueva.min'     => 'La contraseña nueva debe tener al menos 8 caracteres.',
            'password_nueva.regex'   => 'La contraseña nueva debe incluir al menos 1 número y 1 carácter especial.',
            'password_nueva.confirmed' => 'Las contraseñas nuevas no coinciden.',
        ]);

        /** @var Docente $docente */
        $docente = auth('docente')->user();

        if (! Hash::check($request->password_actual, $docente->password)) {
            return back()
                ->withErrors(['password_actual' => 'La contraseña actual no es correcta.'])
                ->with('activeTab', 'opciones');
        }

        // El cast 'hashed' del modelo aplica Hash::make() automáticamente
        $docente->update(['password' => $request->password_nueva]);

        return redirect()->route('docente.dashboard')
            ->with('success', 'Contraseña cambiada exitosamente.')
            ->with('activeTab', 'opciones');
    }

}
