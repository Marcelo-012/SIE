<?php

namespace App\Http\Controllers;

use App\Http\Requests\personas\CompletarPerfilDocenteRequest;
use App\Http\Requests\UpdateDocenteRequest;
use Docente;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

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
    public function show(Docente $docente)
    {
        return view('docentes.show', compact('docente'));
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
}
