<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Jika belum login sama sekali, tendang ke halaman login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Jika sudah login tapi rolenya tidak cocok, larang masuk!
        if (Auth::user()->role !== $role) {
            return abort(403, 'Akses Ditolak! Anda bukan ' . $role);
        }

        return $next($request);
    }
}