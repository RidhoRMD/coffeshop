<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            return match (auth()->user()->role) {
                'admin'   => redirect()->route('admin.dashboard'),
                'kasir'   => redirect()->route('kasir.dashboard'),
                'barista' => redirect()->route('barista.dashboard'),
                default   => redirect('/'),
            };
        }

        return $next($request);
    }
}