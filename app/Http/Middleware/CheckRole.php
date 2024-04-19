<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Si el usuario no está autenticado, redirigirlo al login
            return redirect('/login');
        }

        // Verificar si el rol del usuario coincide con el rol requerido
        if (Auth::user()->role !== $role) {
            // Si el rol del usuario no coincide, denegar el acceso
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        // Permitir el acceso a la ruta
        return $next($request);
    }
}
