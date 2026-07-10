<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExternalVerisMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si NO existe la sesión del usuario externo, redirige al login principal
        if (!session()->has('user_external')) {
            return redirect('/');
        }

        return $next($request);
    }
}