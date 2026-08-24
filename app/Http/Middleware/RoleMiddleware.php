<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Verificar que el usuario tenga el rol requerido.
     *
     * Uso en rutas: ->middleware('role:admin') o ->middleware('role:admin,host')
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user() || !in_array($request->user()->role, $roles)) {
            return redirect('/login')->withErrors([
                'email' => 'No tienes permisos para acceder a esa sección.',
            ]);
        }

        return $next($request);
    }
}
