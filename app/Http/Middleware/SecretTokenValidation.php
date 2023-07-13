<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecretTokenValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    //1. define middleware
    public function handle(Request $request, Closure $next): Response
    {
        if($request->input('token') !== 'top-secret-token'){
            return redirect('home');
        }
        return $next($request);
    }
}
