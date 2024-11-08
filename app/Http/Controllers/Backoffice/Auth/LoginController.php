<?php

namespace App\Http\Controllers\Backoffice\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{

   public function showLoginForm(){

        return view('Backoffice.auth.index');

   }

   public function PostLogin(Request $request)
   {
       // Validation des données du formulaire 
       $request->validate([
           'email' => 'required|email',
           'password' => 'required',
       ], [
           'email.required' => 'L\'adresse email est obligatoire.',
           'email.email' => 'L\'adresse email doit être valide.',
           'password.required' => 'Le mot de passe est obligatoire.',
       ]);
   
       // Authentifier l'utilisateur
       $userdata = [
           'email' => $request->email,
           'password' => $request->password,
           'status' => 1,  
           'usertype' => 99 
       ];
   
       // Authentification de l'utilisateur
       if (Auth::attempt($userdata, $request->has('remember'))) {

           return redirect()->route('spaceDashboard')->with(['isActive' => 'dashboard']);
       }
   
       // Authentification échouée
       return back()->withErrors([
           'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
       ]);
   }
   

    // La page verrouillée
    public function showLocked()
    {
        if (Auth::check()) {
            // Stocker les informations utilisateur dans la session
            Session::put('_email', Auth::user()->email);
            Session::put('_firstname', Auth::user()->firstname);
            Session::put('_lastname', Auth::user()->lastname);
            Session::put('_avatar', Auth::user()->avatar);

            // supprimer des informations spécifiques de la session
            Session::forget('lastActivityTime');

            // Afficher un message d'avertissement
            Session::flash('warning', 'Votre session a bien été verrouillée');

            // Déconnecter l'utilisateur
            Auth::logout();
        }

        return view('Backoffice.auth.locked');
    }

    // Authentification de l'utilisateur à partir de la page verrouillée
    public function PostLocked(Request $request)
    {
        // Validation des données
        $request->validate([
            'password' => 'required',
        ], [
            'password.required' => 'Le mot de passe est obligatoire',
        ]);

        // Récupérer l'email de la session
        $email = Session::get('_email');
        if (!$email) {
            return back()->withErrors([
                'email' => 'Aucune adresse email n\'est associée à cette session.',
            ]);
        }

        // Authentifier l'utilisateur
        if (Auth::attempt(['email' => $email, 'password' => $request->password])) {
            // Authentification réussie
            return redirect()->intended('adminLocked');
        }

        // Authentification échouée
        return back()->withErrors([
            'password' => 'Mot de passe incorrect.',
        ]);
    }

   
    // Déconnexion de l'utilisateur
     public function Logout(){
        Auth::logout();
        return redirect()->route('home')->with('success', 'Vous avez bien été déconnecté !');
    }

}
