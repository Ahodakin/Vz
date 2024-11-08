<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Redirect;

class CheckTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Session::has('lastActivityTime')){
            Session::put('lastActivityTime', time());
        }
        elseif( (time() - Session::get('lastActivityTime')) > (120*60*60) ){
            Session::forget('lastActivityTime');
            Auth::logout(); 
            Session::flash('warning', 'Votre session a expirée. Veuillez vous reconnectez');
            return redirect()->route('spaceLogin');
        }
        elseif( (time() - Session::get('lastActivityTime')) > (60*60*60) ){
            Session::put('_email', Auth::user()->email);
            Session::put('_firstname', Auth::user()->firstname);
            Session::put('_lastname', Auth::user()->lastname);
             Session::put('_avatar', Auth::user()->avatar);
           
            Session::forget('lastActivityTime');
            Session::flash('warning', 'Votre session a été vérouillé pour un temps d\'innactivité trop long');
            Auth::logout();
            return redirect()->route('spaceLocked');
            //return view('app.admin.auth.locked',['user'=>$user]);
        }

        Session::put('lastActivityTime',time());

        return $next($request);
    } 
}
