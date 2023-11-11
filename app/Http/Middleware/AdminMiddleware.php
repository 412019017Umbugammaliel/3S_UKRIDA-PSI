<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa peran pengguna
        if (auth()->check() && auth()->user()->level === 'Admin') {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
