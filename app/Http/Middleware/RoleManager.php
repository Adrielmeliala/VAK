<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $role  // Ini adalah parameter yang kita terima dari route (contoh: '1' atau '2')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek jika user tidak login, arahkan ke halaman login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Cek jika role user tidak sesuai dengan role yang diizinkan dari route
        // Kita menggunakan '==' karena role di DB dan di route adalah integer/string
        if ($request->user()->role != $role) {
            // Jika tidak sesuai, batalkan request dengan error 403 (Forbidden)
            // Anda bisa juga redirect ke halaman lain jika mau.
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // Jika user login dan rolenya sesuai, lanjutkan ke request berikutnya
        return $next($request);
    }
}
