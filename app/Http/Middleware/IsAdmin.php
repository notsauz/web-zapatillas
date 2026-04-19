<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    // Verificar si el usuario autenticado es un administrador
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario no está autenticado o no es administrador, abortar con error 403
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'No tienes permiso para acceder al panel de administración');
        }

        // Si es administrador, continuar con la solicitud
        return $next($request);
    }
}
