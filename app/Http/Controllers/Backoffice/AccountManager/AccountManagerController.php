<?php

namespace App\Http\Controllers\Backoffice\AccountManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Backoffice\Log;
use Illuminate\Support\Carbon;

class AccountManagerController extends Controller
{
    public function showProfile()
    {
        $currentUser = Auth::user();
        return view('Backoffice.backend.profile',compact('currentUser'));
    }

    // Met à jour les informations du profil utilisateur
        public function editProfile (Request $request)
        {
            // Définition des règles de validation
            $rules = [
                'lastname' => 'required|string|max:255',
                'firstname' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'required|email|unique:users,email,' . Auth::id(),
                'gender' => 'required|string',
                'dob' => 'required|date_format:d/m/Y',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ];

            // Messages personnalisés pour les erreurs de validation
            $messages = [
                'email.required' => 'L\'adresse email est obligatoire',
                'email.unique' => 'Cette adresse email est déjà utilisée.',
                'phone.required' => 'Le numéro de téléphone est obligatoire',
                'lastname.required' => 'Le nom de famille est obligatoire',
                'firstname.required' => 'Le prénom est obligatoire',
                'gender.required' => 'Le sexe est obligatoire',
                'dob.required' => 'La date de naissance est obligatoire',
                'dob.date_format' => 'La date de naissance doit être au format JJ/MM/AAAA',
                'avatar.image' => 'Le fichier doit être une image',
                'avatar.mimes' => 'L\'image doit être au format jpeg, png, jpg ou gif',
                'avatar.max' => 'L\'image ne doit pas dépasser 2 Mo',
            ];

            // Validation des données
            $validator = Validator::make($request->all(), $rules, $messages);

            // Si la validation échoue
            if ($validator->fails()) {
                return Redirect::route('profilepage')
                    ->withErrors($validator)
                    ->withInput();
            }

            // Si la validation réussit, mise à jour du profil utilisateur
            $user = Auth::user();
            $user->lastname = $request->lastname;
            $user->firstname = $request->firstname;
            $user->gender = $request->gender;
            $user->dob = Carbon::createFromFormat('d/m/Y', $request->dob)->toDateString();
            $user->email = $request->email;
            $user->contact = $request->phone;

            // Gestion de l'upload de l'avatar
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = $user->id . '-' . time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(170, 170)->save(public_path('back/assets/uploads/avatar').$filename);
                $user->avatar = $filename;
            }

            // Sauvegarde de l'utilisateur dans la base de données
            $user->save();

            // Journalisation et message de succès
            Log::writeInDB('Mise à jour de son profil utilisateur.');
            Session::flash('success', 'Votre profil a bien été mis à jour');

            // Redirection vers la page de profil
            return redirect()->route('profilepage');
        }


        public function editPassword(Request $req)
        {
            // Validation avec messages personnalisés
            $req->validate([
                'email' => 'required|email',
                'newpassword' => 'required|min:8|confirmed', // 'confirmed' attend un champ 'newpassword_confirmation'
            ], [
                'email.required' => 'Le champ email est obligatoire.',
                'email.email' => 'Le champ email doit être une adresse e-mail valide.',
                'newpassword.required' => 'Le champ nouveau mot de passe est obligatoire.',
                'newpassword.min' => 'Le champ nouveau mot de passe doit contenir au moins :min caractères.',
                'newpassword.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            ]);

            User::where('email', $req['email'])->update(['password' => Hash::make($req['newpassword'])]);

            Log::writeInDB('Mise à jour du mot de passe utilisateur.');

            Session::flash('success', 'Votre mot de passe a bien été mis à jour');

            return redirect()->route('profilepage');
        }



        public function checkPwd(Request $req)
        {
            // Recherche l'utilisateur par son email
            $user = User::where('email', $req['email'])->first();

            // Vérifie si le mot de passe donné correspond au mot de passe haché dans la base de données
            if (Hash::check($req['password'], $user->password)) {
                die('1'); // Mot de passe correct
            } else {
                die('0'); // Mot de passe incorrect
            }
        }

}


