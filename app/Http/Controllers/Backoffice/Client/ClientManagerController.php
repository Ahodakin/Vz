<?php

namespace App\Http\Controllers\Backoffice\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
use App\Models\Make;
use App\Models\autoCategories;
use App\Models\City;
use App\Models\Job;
use App\Models\Periode;
use App\Models\autoGuarantee;
use App\Models\autoInfos;
use App\Models\autoCompany;
use App\Models\OptionnalService;
use App\Models\User;
use App\Models\assuranceAutoInfos;
use App\Models\Backoffice\Quotation;
use App\Models\Log;

class ClientManagerController extends Controller
{
        //gerer mes clients
        public function afficherClient()
        {
            // Récupérer les marques avec les modèles associés
            $makes = Make::with('models')->get();
        
            // Récupérer les catégories auto activées
            $categories = autoCategories::where('enabled', 1)->get();
        
            // Récupérer toutes les villes
            $zones = City::all();
        
            // Récupérer tous les emplois
            $jobs = Job::all();
        
            // Récupérer les garanties
            $guarantees = autoGuarantee::all();
        
            // Récupérer les clients avec le statut de quotation 5, en comptant le nombre de quotations
            $clients = Quotation::with('user') // Assurez-vous que la relation est définie dans le modèle Quotation
                ->where('status', 5)
                ->select("user_id", DB::raw("count(id) as nb_quote"))
                ->groupBy('user_id')
                ->latest() // Pour obtenir les clients les plus récents
                ->get();
        
            // Passer les données à la vue
            return view('Backoffice.backend.client.afficher-client')->with([
                'isActive' => 'clientmanager',
                'clients' => $clients,
                'jobs' => $jobs,
                'makes' => $makes,
                'categories' => $categories,
                'zones' => $zones,
                'guarantees' => $guarantees
            ]);
        }
        


    public function detailClient($id)
    {
      $devis = DB::select('SELECT 
      number_n,
      policy_number,
      firstname,
      lastname,
      email,
      contact,
      product_type,
      matriculation,
      power,
      energy,
      placesnumber,
      parkingzone,
      vneuve,
      vvenale,
      reduction_commerciale,
      assurance_auto_infos.releasedate as assurance_release_date,
      assurance_auto_infos.id as assurance_auto_info_id,
      subscription_type,
      quotation.status,
      quotation.id as qid,
      quotation.created_at,
      quotation.updated_at,
      auto_infos.id as auto_info_id,
      users.id as uid,
      guarante,
      assurance_auto_infos.id as aid
      from 
      quotation,
      assurance_auto_infos,
      auto_infos,
      users
      where users.id=user_id and auto_infos.id=product_id and users.id="'.$id.'" and  assurance_auto_infos.id=assurance_infos_id');

      $commandes = DB::select('SELECT 
      number_n,
      policy_number,
      firstname,
      lastname,
      email,
      contact,
      product_type,
      matriculation,
      power,
      energy,
      placesnumber,
      parkingzone,
      vneuve,
      vvenale,
      reduction_commerciale,
      assurance_auto_infos.releasedate as assurance_release_date,
      assurance_auto_infos.id as assurance_auto_info_id,
      subscription_type,
      quotation.status,
      quotation.id as qid,
      quotation.created_at,
      quotation.updated_at,
      auto_infos.id as auto_info_id,
      users.id as uid,
      guarante,
      assurance_auto_infos.id as aid
      from 
      quotation,
      assurance_auto_infos,
      auto_infos,
      users
      where users.id=user_id and auto_infos.id=product_id and users.id="'.$id.'" and quotation.status>=2 and  assurance_auto_infos.id=assurance_infos_id');

      $contrats = DB::select('SELECT 
      number_n,
      policy_number,
      firstname,
      lastname,
      email,
      contact,
      product_type,
      matriculation,
      power,
      energy,
      placesnumber,
      parkingzone,
      vneuve,
      vvenale,
      reduction_commerciale,
      assurance_auto_infos.releasedate as assurance_release_date,
      assurance_auto_infos.id as assurance_auto_info_id,
      subscription_type,
      quotation.status,
      quotation.id as qid,
      quotation.created_at,
      quotation.updated_at,
      auto_infos.id as auto_info_id,
      users.id as uid,
      guarante,
      assurance_auto_infos.id as aid
      from 
      quotation,
      assurance_auto_infos,
      auto_infos,
      users
      where users.id=user_id and auto_infos.id=product_id and users.id="'.$id.'" and quotation.status=5 and  assurance_auto_infos.id=assurance_infos_id');



      $client = User::where('id', $id)->get();
      $makes = DB::table('make')
        ->join('model','make.id','=','model.make_id')
        ->select('make.*','model.id as modid','model.title as modtitle')
        ->get();
      $categories = autoCategories::where('enabled', 1)->get();
      $zones = City::all();
      $periodes = Periode::all();
      $guarantees = autoGuarantee::all();
      $clients = User::all();
      $jobs = Job::all();
      return view('Backoffice/backend/client/client-detail')->with([
        'isActive'=>'clientmanager',
        'client'=> $client,
        'devis' =>  $devis,
        'commandes' =>  $commandes,
        'contrats' =>  $contrats,
        'categories'=>$categories,
        'makes'=> $makes,
        'zones'=> $zones,
        'jobs'=> $jobs,
        'guarantees'=> $guarantees,
        'periodes'=> $periodes
        ]);
    }

       
}
