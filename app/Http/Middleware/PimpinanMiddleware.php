<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PimpinanMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!in_array(auth()->user()->role, ['admin', 'pimpinan'])) {
            return redirect('/login')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}