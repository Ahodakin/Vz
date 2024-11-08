<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Company; 
use App\Models\ProductContract; 
use App\Models\Backoffice\Quotation; 
use App\Models\Backoffice\AutoCompany; 
use App\Models\Backoffice\Sinistre; 
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\CallmeLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class AdminController extends Controller
{
    // public function showDashboard()
    // {
    //     // Récupérer les dates de début et de fin depuis la requête ou utiliser des valeurs par défaut
    //     $start = request()->input('start', Carbon::now()->subMonth()->format('Y-m-d'));
    //     $end = request()->input('end', Carbon::now()->format('Y-m-d'));
    //     // Récupérer les dates de début et de fin depuis la requête ou utiliser des valeurs par défaut
    //     $start = request()->input('start', Carbon::now()->subMonth()->format('Y-m-d'));
    //     $end = request()->input('end', Carbon::now()->format('Y-m-d'));

    //     // Récupérer les données
    //     $confirm_1 = $this->newDevis($start, $end)->count();
    //     $processiong_2 = $this->waitingTraitement($start, $end);
    //     $pending_3 = $this->waitingDelivery($start, $end)->count();
    //     $delivery_4 = $this->deliveriedOrder($start, $end);
    //     $complete_5 = $this->completedOrder($start, $end);
    //     $cancel_6 = $this->canceledOrder($start, $end);
    //     // Récupérer les données
    //     $confirm_1 = $this->newDevis($start, $end)->count();
    //     $processiong_2 = $this->waitingTraitement($start, $end);
    //     $pending_3 = $this->waitingDelivery($start, $end)->count();
    //     $delivery_4 = $this->deliveriedOrder($start, $end);
    //     $complete_5 = $this->completedOrder($start, $end);
    //     $cancel_6 = $this->canceledOrder($start, $end);

    //     // Récupérer les dernières commandes et prospects
    //     // Récupérer les dernières commandes et prospects
    //     $orders = $this->lastFiveOrders($start, $end);
    //     $prospects = $this->waitingDelivery($start, $end);
        
    //     // Retourner la vue avec les données
        // return view('Backoffice.backend.dashboard', compact(
        //     'confirm_1', 
        //     'processiong_2', 
        //     'pending_3', 
        //     'delivery_4', 
        //     'complete_5', 
        //     'cancel_6',
        //     'orders',
        //     'prospects',
        // ));
    // }

    // private function newDevis($start = null, $end = null)
    // {
    //     $query = Quotation::query(); 

    //     if ($start && $end) {
    //         $query->whereBetween('created_at', [$start, $end]);
    //     }

    //     return $query->get();
    // }


    // private function waitingTraitement($start = null, $end = null)
    // {
    //     $query = Quotation::where('status', '1'); 

    //     if ($start && $end) {
    //         $query->whereBetween('created_at', [$start, $end]);
    //     }

    //     return $query->count(); 
    // }


    // private function waitingDelivery($start = null, $end = null)
    // {
    //     $query = Quotation::where('status', '2'); 

    //     if ($start && $end) {
    //         $query->whereBetween('created_at', [$start, $end]);
    //     }
    
    //     return $query->get();
    // }



    // private function deliveriedOrder($start = null, $end = null)
    // {
    //     $query = Quotation::where('status', '3');

    //     if ($start && $end) {
    //         $query->whereBetween('created_at', [$start, $end]);
    //     }

    //     return $query->count();
    // }



    // private function completedOrder($start = null, $end = null)
    // {
    //     $query = Quotation::where('status', '4'); 

    //     if ($start && $end) {
    //         $query->whereBetween('created_at', [$start, $end]);
    //     }

    //     return $query->count(); 
    // }



    // private function canceledOrder($start = null, $end = null)
    // {
    //     $query = Quotation::where('status', '-1'); 

    //     if ($start && $end) {
    //         $query->whereBetween('created_at', [$start, $end]);
    //     }

    //     return $query->count();
    // }
    public function showDashboard()
    {
        if (Auth::check()){
        $confirm_1 = sizeof(newDevis());
            $processiong_2 = waitingTraitement()->count();
            $pending_3 = waitingDelivery()->count();
            $delivery_4 = deliveriedOrder()->count();
            $complete_5 = completedOrder()->count();
            $cancel_6 = canceledOrder()->count();

            return view('Backoffice.backend.dashboard', compact(
                'confirm_1', 
                'processiong_2', 
                'pending_3', 
                'delivery_4', 
                'complete_5', 
                'cancel_6',
                // 'orders',
                // 'prospects',
            ));
        }
        else{
            return view('Backoffice.auth.index');
        }
    }


    


    public function getOnlineUsers()
    {
        // Récupérer tous les utilisateurs
        $users = User::all();
        
        // Filtrer pour trouver ceux qui sont en ligne
        $onlineUsers = $users->filter(function ($user) {
            return Cache::has('user-is-online-' . $user->id);
        });

        return $onlineUsers;
    }


    public function deliveryManStats($start = null, $end = null)
    {
        $query = DB::table('delivery_tour')
            ->join('users', 'users.id', '=', 'delivery_tour.deliveryman_id')
            ->select('users.firstname', 'users.lastname', 'deliveryman_id', DB::raw('COUNT(delivery_tour.deliveryman_id) as nb'));

        if ($start && $end) {
            $query->whereBetween("delivery_tour.created_at", [$start, $end]);
        }

        return $query->groupBy('deliveryman_id')->get();
    }


    private function lastFiveOrders($start = null, $end = null)
    {
        $query = Quotation::query();

        if ($start && $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        return $query->orderBy('created_at', 'desc')->take(5)->get();
    }




    private function getAllProductContractsCount($start = null, $end = null)
    {
        $query = AutoCompany::query();

        if ($start && $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        return $query->count();
    }


    private function getSaleByCompany($start = null, $end = null)
    {
        $query = DB::table('auto_company')
            ->selectRaw('auto_company.compname as compname, COUNT(quotation.id) as sales')
            ->join('quotation', 'quotation.company_id', '=', 'auto_company.id')
            ->groupBy('auto_company.compname');

        if ($start && $end) {
            $query->whereBetween('quotation.created_at', [$start, $end]);
        }


        return $query->get();
    }


    // public function declarerSinistre(Request $request)
    // {
    //     $date_sinistre = $request->get('date_sinistre'); // Corrigé ici
    //     $lieu_accident = $request->get('lieu_accident'); // Corrigé ici
    //     $quotation_id = $request->get('quotation_id'); // Corrigé ici
    //     $circonstance_accident = $request->get('client_declaration'); // Corrigé ici
    //     $temoin_nom = $request->get('temoin_nom'); // Corrigé ici
    //     $temoin_adresse = $request->get('temoin_adresse'); // Corrigé ici
    //     $constat = $request->get('constat');
    //     $constat_maker = $request->get('constat_maker'); // Corrigé ici
    
    //     // Insérer dans la table sinistre
    //     $id = DB::table('sinistre')->insertGetId([
    //         'date_sinistre' => $date_sinistre,
    //         'lieu_accident' => $lieu_accident,
    //         'quotation_id' => $quotation_id,
    //         'client_declaration' => $circonstance_accident,
    //         'temoin_nom' => $temoin_nom,
    //         'temoin_adresse' => $temoin_adresse,
    //         'constat' => $constat,
    //         'constat_maker' => $constat_maker
    //     ]);
    
    //     if ($id) {
    //         $this->trace("Déclaration de sinistre", "Déclaration de sinistre", Auth::user()->id);
    //         return response()->json(['success' => true, 'id' => $id]);
    //     } else {
    //         return response()->json(['success' => false]);
    //     }
    // }
    
  



    public function declarerSinistre(Request $request)
    {
        $date_sinistre = $request->get('date_sinistre'); // Corrigé ici
        $lieu_accident = $request->get('lieu_accident'); // Corrigé ici
        $quotation_id = $request->get('quotation_id'); // Corrigé ici
        $circonstance_accident = $request->get('client_declaration'); // Corrigé ici
        $temoin_nom = $request->get('temoin_nom'); // Corrigé ici
        $temoin_adresse = $request->get('temoin_adresse'); // Corrigé ici
        $constat = $request->get('constat');
        $constat_maker = $request->get('constat_maker'); // Corrigé ici
    
        // Insérer dans la table sinistre
        $id = DB::table('sinistre')->insertGetId([
            'date_sinistre' => $date_sinistre,
            'lieu_accident' => $lieu_accident,
            'quotation_id' => $quotation_id,
            'client_declaration' => $circonstance_accident,
            'temoin_nom' => $temoin_nom,
            'temoin_adresse' => $temoin_adresse,
            'constat' => $constat,
            'constat_maker' => $constat_maker
        ]);
    
        if ($id) {
            $this->trace("Déclaration de sinistre", "Déclaration de sinistre", Auth::user()->id);
            return response()->json(['success' => true, 'id' => $id]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    // public function declarerSinistre(Request $request)
    // {
    //   $accident_date =$request->get('date');
    //   $lieu_accident =$request->get('lieu');
    //   $quotation_id =$request->get('qid');
    //   $circontance_accident =$request->get('circonstance');
    //   $temoin_nom =$request->get('temoin');
    //   $temoin_adresse =$request->get('adresse');
    //   $constat =$request->get('constat');
    //   $constat_maker =$request->get('contat_maker');
  
    //   $id = DB::table('sinistre')->insertGetId([
    //   'accident_date' => $accident_date,
    //   'lieu_accident' => $lieu_accident,
    //   'quotation_id' => $quotation_id,
    //   'circontance_accident' => $circontance_accident,
    //   'temoin_nom' =>  $temoin_nom,
    //   'temoin_adresse' => $temoin_adresse,
    //   'constat' => $constat,
    //   'constat_maker' => $constat_maker
    //   ]);
  
    //   if($id)
    //   {
    //     $this->trace("Déclaration de sinistre","Declaration de sinistre",Auth::user()->id);
    //     echo $id;
    //   }
    //   else
    //   {
    //     echo 0;
    //   }
    // }
    
    #gestion des sinistres
    public function getSinistre()
    {
      $sinistres = DB::select('SELECT 
      quotation.id as qid,
      sinistre.id as sid,
      accident_date,
      lieu_accident,
      quotation_id,
      circontance_accident,
      temoin_nom,
      temoin_adresse,
      constat,
      constat_maker,
      firstname,
      lastname,
      number_n,
      policy_number
      from 
      sinistre,
      quotation,
      users
      Where quotation_id = quotation.id and users.id = quotation.user_id
      ');
  
      return view('app/backend/editer-sinistre')->with([
      'isActive' => 'sinistre',
      'sinistres'=> $sinistres
      ]);
    }
  
    public function sinistreDetail($id)
    {
      $sinistre = DB::select('SELECT 
      accident_date,
      lieu_accident,
      quotation_id,
      circontance_accident,
      temoin_nom,
      temoin_adresse,
      constat,
      constat_maker,
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
      firstrelease,
      placesnumber,
      parkingzone,
      vneuve,
      vvenale,
      city,
      reduction_commerciale,
      assurance_auto_infos.releasedate as assurance_release_date,
      assurance_auto_infos.id as assurance_auto_info_id,
      periode.periode,
      periode.id as pid,
      subscription_type,
      city.id as cid,
      quotation.status,
      quotation.delivery_location,
      quotation.phone_client,
      quotation.company_id as id_comp,
      quotation.id as qid,
      model.id as mid,
      make.id as makid,
      quotation.id as qid,
      auto_categories.id as autid,
      model.code,
      make.title,
      auto_categories.categorie,
      auto_infos.id as auto_info_id,
      users.id as uid,
      guarante
      from 
      quotation,
      assurance_auto_infos,
      auto_infos,
      users,
      model,
      make,
      auto_categories,
      city,
      periode,
      sinistre
      where users.id=user_id and auto_infos.id=product_id and quotation.id=quotation_id and  assurance_auto_infos.id=assurance_infos_id and model.id=auto_infos.model_id and auto_categories.id=auto_infos.category and city.id=auto_infos.parkingzone and periode.id=assurance_auto_infos.periode and sinistre.id="'.$id.'"
      limit 10')[0];
      return view('app/backend/sinistre-detail')->with([
      'isActive'=>'sinistre',
      'sinistre'=> $sinistre
      ]);
    }
}
