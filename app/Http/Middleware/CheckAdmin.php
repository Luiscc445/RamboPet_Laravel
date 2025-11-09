<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !in_array(auth()->user()->rol, ['admin', 'recepcionista'])) {
            return redirect('/veterinario');
        }

        return $next($request);
    }
}
