<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifier si l'utilisateur est authentifié
        if (Auth::check()) {
            // Vérifier si l'utilisateur a le rôle demandé
            if (Auth::check() && Auth::user()->hasRole($role)) {
                return $next($request);
            }
            
        }

        // Rediriger si l'utilisateur n'a pas le rôle
        return redirect()->route('/')->with('error', 'Vous n\'avez pas accès à cette page');
    }
}

