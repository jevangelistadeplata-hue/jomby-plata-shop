<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Permite el acceso solamente al rol indicado.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Verifica que exista un usuario autenticado.
        if (!$request->user()) {
            abort(401, 'Debes iniciar sesión para acceder a esta sección.');
        }

        // Verifica que el usuario tenga el rol requerido.
        if (!$request->user()->role || $request->user()->role->name !== $role) {
            abort(403, 'No tienes autorización para acceder a esta sección.');
        }

        return $next($request);
    }
}