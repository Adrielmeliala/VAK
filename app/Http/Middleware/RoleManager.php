<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * 
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        if (!Auth::check()) {
            return redirect('login');
        }

        if ($request->user()->role != $role) {

            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        return $next($request);
    }
}
