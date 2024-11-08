<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function guard()
    {
        return Auth::guard('space_perso');
    }

    public function login(Request $request)
    {
        $rules = [
            'phone_number' => 'required',
            'password' => 'required',
        ];

        $messages = [
            'phone_number.required' => 'Le N° de téléphone est obligatoire',
            'password.required' => 'Le mot de passe est obligatoire',
        ];

        // Utilisation de $request à la place de Input
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Session::flash('error', 'N° de téléphone et mot de passe obligatoire');
            return Redirect::to('spaceLogin')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        } else {
            $userdata = [
                'phone_number' => str_replace(" ", "", $request->input('phone_number')),
                'password' => $request->input('password'),
            ];

            if (Auth::guard('space_perso')->attempt($userdata)) {
                $user = Auth::guard('space_perso')->user();

                if ($user->status == 0) {
                    Session::flash('error', 'Votre compte n\'est pas actif. Contactez nous (225) 220 170 00');
                    auth('space_perso')->logout();
                    return Redirect()->route('home');
                } elseif ($user->status == -1) {
                    Session::flash('error', 'Votre compte a été supprimé. Contactez nous (225) 220 170 00');
                    auth('space_perso')->logout();
                    return Redirect()->route('home');
                } else {
                    return redirect()->route('page.myspace')->with(['active' => 'myspace']);
                }
            } else {
                Session::flash('error', 'N° de téléphone ou mot de passe incorrect');
                return Redirect::back()->withInput($request->except('password'));
            }
        }
    }
}
