<?php

namespace App\Http\Middleware;

use App\Models\Shift;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckShiftAktif
{
    public function handle(Request $request, Closure $next): Response
    {
        $shiftAktif = Shift::where('kasir_id', Auth::id())
            ->where('status', 'buka')
            ->first();

        if (!$shiftAktif) {
            return redirect()->route('kasir.shift.buka');
        }

        return $next($request);
    }
}