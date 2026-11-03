<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->role !== $role) {
            if ($role === 'admin') {
                return redirect()->route('user.kuesioner.index')
                    ->with('error', 'Akses ditolak. Halaman ini hanya untuk Admin.');
            }
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
