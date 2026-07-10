<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerisMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si NO existe la sesión del usuario de la empresa, redirige a /empresarial
        if (!session()->has('user_veris')) {
            return redirect('/empresarial');
        }

        return $next($request);
    }
}