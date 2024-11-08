<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackUserActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Stocker l'utilisateur en cache avec un délai d'expiration
            $expiresAt = now()->addMinutes(5); // L'utilisateur est considéré en ligne pour 5 minutes
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
        }

        return $next($request);
    }
}
