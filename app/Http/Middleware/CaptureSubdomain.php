<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CaptureSubdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ambiente = env('APP_ENV');
        $host = $request->getHost();
        // $subdomain = explode('.', $host)[1];
        if($host !== "127.0.0.1"){
            if(Str::contains($host, 'veris')){
                $subdomain = 'veris';
            }else{
                $subdomain = 'parami';
            }
        }else{
            $subdomain = 'veris';
        }

        Session::forget('subdomain');
        Session::put('subdomain', $subdomain);
        // Session::put('subdomain', 'parami');
        config(['app.subdomain' => Session::get('subdomain')]);
        // dump(Session::get('subdomain'));
        
        return $next($request);
    }
}
