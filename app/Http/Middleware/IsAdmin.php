<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user belum login atau role-nya BUKAN admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Lempar halaman 403 (Forbidden) atau redirect ke dashboard biasa
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}