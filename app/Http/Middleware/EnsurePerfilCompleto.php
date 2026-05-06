<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePerfilCompleto
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('docente')->check() && !Auth::guard('docente')->user()->perfil_completo) {
            if (!$request->routeIs('docentes.completar-perfil*')) {
                return redirect()->route('docentes.completar-perfil');
            }
        }
        return $next($request);
    }
}
