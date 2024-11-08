<?php

namespace App\Http\Controllers\Backoffice\UsersManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Backoffice\Role;
use App\Models\Backoffice\Quotation;
use App\Models\Backoffice\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UsersManagerController extends Controller
{

    public function showUsersList()
    {
		$prospects = User::withCount(['quotations' => function ($query) {
			$query->where('status', '<', 5);
		}])
		->whereHas('quotations', function ($query) {
			$query->where('status', '<', 5);
		})
		->where('status', '<>', -1)
		->orderBy('id', 'desc')
		->get();
	
		$clients = User::withCount(['quotations' => function($query) {
			$query->where('status', 5);
		}])->where('status', '<>', -1)
		  ->orderBy('id', 'desc')
		  ->get();
		

    	$admin_aroli = User::where([
    		['usertype','=',99],
    		['status','<>', -1]
    	])->get();

    	$roles = Role::all();

    	return view('Backoffice.backend.usersmanagement.users', compact('roles','admin_aroli','clients','prospects'));
    }


	public function getUser($id_user)
    {
    	$user = User::where('id', $id_user)->first();

    	if($user) 
    		return response()->json($user);
    	else 
    		echo 0;
    }

	public function createUser(Request $req)
	{
		// Vérifie si l'email existe déjà dans la base de données
		if (User::check_mail($req['email']) != null) {
			Session::flash('error', 'Cette adresse email existe déjà');
			return redirect()->back(); 
		} else {
			// Récupère toutes les données du formulaire
			$input = $req->all();
	
			// Hash du mot de passe
			$input['password'] = Hash::make($req['password']);
		
			// Définit un avatar par défaut
			$input['avatar'] = 'default.png';
		
			// Convertit la date de naissance au format approprié
			$input['dob'] = Carbon::createFromFormat("d/m/Y", $req['dob'])->toDateString();
		
			// Crée l'utilisateur avec les données fournies
			$user = User::create($input);
	
			// Vérifiez si un ou plusieurs rôles sont fournis
			if (!empty($req['roles'])) {
				// Attach roles (Utiliser attach ou sync)
				$user->roles()->sync($req['roles']); // Supprime les anciens rôles et attache les nouveaux
			}
	
			// Envoie un message de succès à la session
			Session::flash('success', 'L\'utilisateur a bien été créé');
			return redirect()->back(); // Redirection vers la page précédente
		}
	}


	public function showUserDetails($id_user)
    {
        $user = User::where('id', $id_user)->first();
        $roles = Role::all();
        $logs = Log::where('user_id', $id_user)->orderBy('id', 'desc')->get();
        return view('Backoffice.backend.usersmanagement.user-details', compact('user', 'roles', 'logs'))
            ->with(['isActive' => 'usersmanager']);
    }


    public function editUser(Request $request)
    {
    	$input = $request->all();
    	$user = User::find($request['iduser']);
        $input['dob'] = ($request['dob'])? Carbon::createFromFormat("d/m/Y", $request['dob'])->toDateString() : null;;
        $user->update($input);
    	
    	Session::flash('success','L\'utilisateur a bien été mis à jour');
	    return redirect()->back();
    }

	public function editUserRole(Request $req)
    {
        
		// Remove old roles
		DB::table('role_user')->where('user_id', $req['iduser'])->delete();

		// Find user
		$user = User::find($req['iduser']);

		// Attach new roles
		if (!empty($req['roles'])) {
			// Attach roles (Utiliser attach ou sync)
			$user->roles()->sync($req['roles']); // Supprime les anciens rôles et attache les nouveaux
		}

    	
    	Session::flash('success','Le Rôle  de l\'utilisateur a bien été mis à jour');
	    return redirect()->route('userDetails',$req['iduser']);
    }

	public function deleteUser($id_user)
	{
		// Rechercher l'utilisateur et mettre à jour son statut à -1 (désactivé)
		User::where('id', $id_user)->update([
			'status' => '-1'
		]);
	}

}
