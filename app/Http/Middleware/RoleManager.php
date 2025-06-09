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
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }

        if (Auth::user()->role == 0) { // Asumsi role admin adalah 0
            return $next($request);
        }

        $authUserRole = Auth::user()->role;

        switch($role){
            case 'admin':
                if($authUserRole == 0){
                    return $next($request);
                }
                break;
            
            case 'customer':
                if($authUserRole == 1){
                    return $next($request);
                }
                break;
        }
        abort(403, 'Unauthorized Action');

        switch($authUserRole){
            case 0:
                return redirect()->route('admin');

            case 1:
                return redirect()->route('user');
        }

        return redirect()->route('login');

    }

    
}
