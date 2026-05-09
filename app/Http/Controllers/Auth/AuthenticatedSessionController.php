<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa el login, obtiene el guard usado y redirige al dashboard correcto.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $guard = $request->authenticate();

        $request->session()->regenerate();

        return match ($guard) {
            'docente' => redirect()->route('docente.dashboard'),
            'alumno'  => redirect()->route('alumno.dashboard'),
            default   => redirect()->intended(route('dashboard', absolute: false)),
        };
    }

    /**
     * Cierra la sesión del guard activo (docente, alumno o web).
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Determinar qué guard está autenticado y cerrar solo ese
        foreach (['docente', 'alumno', 'web'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
                break;
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
