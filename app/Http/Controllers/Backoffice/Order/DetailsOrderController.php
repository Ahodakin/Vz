<?php

namespace App\Http\Controllers\Backoffice\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Http\Controllers\Backoffice\AnotherController;
use App\Models\Backoffice\Quotation;
use App\Models\Make;
use App\Models\Backoffice\autoCategories;
use App\Models\Backoffice\City;
use App\Models\Periode;
use App\Models\User;
use App\Models\Backoffice\autoGuarantee;
use App\Models\Backoffice\Job;
use App\Models\Backoffice\CarType;
use App\Models\Backoffice\AssuranceAutoInfos;
use App\Models\Backoffice\AssuranceVoyageInfos;
use App\Models\Backoffice\OrderStatusActor;


class DetailsOrderController extends Controller
{
    public function commandeTraiter()
    {
      $commandes = DB::select('SELECT 
      number_n,
      policy_number,
      firstname,
      lastname,
      email,
      contact,
      product_type,
      quotation.status,
      quotation.created_at,
      quotation.id as qid,
      assurance_infos_id as aid
      from 
      quotation,
      users
      where users.id=user_id and quotation.status=5 order by quotation.id desc');
      return view('Backoffice.backend.order.commande-traiter')->with(['isActive'=>'commandes','commandes'=>$commandes]);
    }

    public function Quotedetails($id, $aid)
    {
        $prospect = Quotation::with(['assuranceAutoInfo', 'autoInfo', 'user', 'job', 'city'])
            ->where('id', $id)
            ->first();
    
        if (!$prospect) {
            Session::flash('error', 'Une erreur s\'est produite');
            return redirect()->route('spaceDashboard')->with(['isActive' => 'dashboard']);
        }
    
        $guaranty = AssuranceAutoInfos::find($aid);
        if (!$guaranty) {
            Session::flash('error', 'Une erreur s\'est produite');
            return redirect()->route('spaceDashboard')->with(['isActive' => 'dashboard']);
        }
    
        $guarantees_array = $this->garantie_to_array($guaranty->guarante);
    
        if (is_null($prospect->collect_data)) {
            $quotations = json_decode(app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->autoInfo->id, $prospect->user_id, $prospect->assurance_auto_info_id));
    
            $prospect->update([
                "collect_data" => json_encode($quotations)
            ]);
        } else {
            $quotations = json_decode($prospect->collect_data);
        }
    
        $optional_service = DB::table('optional_service')->where(['product_type' => 1])->get();
        $selected_serv = collect($quotations[0]->servopt ?? []);
    
        $revives = DB::table('revive_client_quotation')->where('quotation_id', $id)->get();
    
        $order_status = DB::table('order_status_actor')
            ->join('quotation', 'quotation.id', '=', 'order_status_actor.order_id')
            ->join('users', 'users.id', '=', 'order_status_actor.actor_id')
            ->select('user_id', 'firstname', 'lastname', 'usertype', 'number_n', 'quotation.status as current_status', 'policy_number', 'order_id', 'order_status', 'order_status_actor.created_at', 'order_status_actor.updated_at')
            ->where('order_status_actor.order_id', $id)
            ->groupBy('order_status')
            ->orderBy('order_status')
            ->get();
    
        // Corrected line to fetch the client
        $client = User::find($prospect->user_id); // Assuming prospect has a user_id field
    
        $prospect->update([
            "view" => 1
        ]);
    
        return view('Backoffice.backend.prospection.details-devis')->with([
            'isActive' => 'commande',
            'categories' => AutoCategories::where('enabled', 1)->get(),
            'makes' => Make::all(),
            'zones' => City::all(),
            'jobs' => Job::where('enabled', 1)->orderBy('jobtitle')->get(),
            'car_types' => CarType::where('car_type_status', 1)->get(),
            'guarantees' => autoGuarantee::all(),
            'periodes' => Periode::all(),
            'prospect' => $prospect,
            'guarantees_array' => $guarantees_array,
            'quotations' => $quotations,
            'optional_service' => $optional_service,
            'selected_serv' => $selected_serv,
            'revives' => $revives,
            'order_status' => $order_status,
            'client' => $client, // Make sure there is no extra space in the key
        ]);
    }
    

    
    public function garantie_to_array($guarante)
    {
        // Conversion de la garantie en tableau
        return json_decode($guarante, true);
    }

    public function commandeAencaisser()
    {
      $commandes = orderToTrait()->select("quotation.*","firstname","lastname","contact","email")->orderBy('quotation.id','desc')->get();

      return view('Backoffice.backend.order.commande-a-encaisser')->with(['isActive'=>'encaisser','commandes'=>$commandes]);
    }
    // public function commandeAencaisser()
    // {
    //   $commandes = orderToTrait()->select("quotation.*","firstname","lastname","contact","email")->orderBy('quotation.id','desc')->get();

    //   return view('Backoffice.backend.order.commande-a-encaisser')->with(['isActive'=>'encaisser','commandes'=>$commandes]);
    // }

    public function TravelQuotedetails($id, $aid)
    {
        // Charger les détails de la cotation avec les relations associées
        $prospect = Quotation::with([
            'assuranceVoyageInfo.pays', 
            'user', 
            'orderStatusActors.user', 
        ])->findOrFail($id);


        if ($prospect) {
            // Calcul des cotations
            if ($prospect->collect_data == null) {
                $quotations = json_decode(app('App\Http\Controllers\Backoffice\Quotation\VoyageQuotationController')->caculVoyageQuotationFromDb($prospect));
                $prospect->update([
                    "collect_data" => app('App\Http\Controllers\Backoffice\Quotation\VoyageQuotationController')->caculVoyageQuotationFromDb($prospect)
                ]);
            } else {
                $quotations = json_decode($prospect->collect_data);
            }

        if ($prospect) {
            // Calcul des cotations
            if ($prospect->collect_data == null) {
                $quotations = json_decode(app('App\Http\Controllers\Backoffice\Quotation\VoyageQuotationController')->caculVoyageQuotationFromDb($prospect));
                $prospect->update([
                    "collect_data" => app('App\Http\Controllers\Backoffice\Quotation\VoyageQuotationController')->caculVoyageQuotationFromDb($prospect)
                ]);
            } else {
                $quotations = json_decode($prospect->collect_data);
            }
    
            $optional_service = DB::table('optional_service')->where(['product_type' => 3])->get();
            // Vérifiez si quotations[0] existe et s'il a la propriété SERVICES
            if (isset($quotations[0]) && isset($quotations[0]->SERVICES)) {
                $selected_serv = collect($quotations[0]->SERVICES);
            } else {
                // Gérer le cas où SERVICES n'est pas défini
                $selected_serv = collect(); // Ou une valeur par défaut
            }
            // Vérifiez si quotations[0] existe et s'il a la propriété SERVICES
            if (isset($quotations[0]) && isset($quotations[0]->SERVICES)) {
                $selected_serv = collect($quotations[0]->SERVICES);
            } else {
                // Gérer le cas où SERVICES n'est pas défini
                $selected_serv = collect(); // Ou une valeur par défaut
            }
            $revives = DB::table('revive_client_quotation')->where('quotation_id', $id)->get();
    
            $order_status = $prospect->orderStatusActors;
    
            // Marquer la cotation comme vue
            $prospect->update(["view" => 1]);
    
            // Obtenir les compagnies et les pays
            $companies = DB::table('auto_company')->where(['has_travel' => 1])->get();
            $pays = DB::table('pays')->get();
    
            return view('Backoffice.backend/prospection/details-devis-voyage')->with([
                'isActive' => 'commande',
                'prospect' => $prospect,
                'quotations' => $quotations,
                'optional_service' => $optional_service,
                'selected_serv' => $selected_serv,
                'companies' => $companies,
                'pays' => $pays,
                'revives' => $revives,
                'order_status' => $order_status,
            ]);

            $optional_service = DB::table('optional_service')->where(['product_type' => 3])->get();
            $selected_serv = collect($quotations[0]->SERVICES);
            $revives = DB::table('revive_client_quotation')->where('quotation_id', $id)->get();
    
            $order_status = $prospect->orderStatusActors;
    
            // Marquer la cotation comme vue
            $prospect->update(["view" => 1]);
    
            // Obtenir les compagnies et les pays
            $companies = DB::table('auto_company')->where(['has_travel' => 1])->get();
            $pays = DB::table('pays')->get();
    
            return view('Backoffice.backend/prospection/details-devis-voyage')->with([
                'isActive' => 'commande',
                'prospect' => $prospect,
                'quotations' => $quotations,
                'optional_service' => $optional_service,
                'selected_serv' => $selected_serv,
                'companies' => $companies,
                'pays' => $pays,
                'revives' => $revives,
                'order_status' => $order_status,
            ]);
        } else {
            Session::flash('error', 'Une erreur s\'est produite');
            return redirect()->route('spaceDashboard')->with(['isActive' => 'dashboard']);

            Session::flash('error', 'Une erreur s\'est produite');
            return redirect()->route('spaceDashboard')->with(['isActive' => 'dashboard']);
        }
    }
    
    }
    

    public function OrderTimeLine($id)
    {
        // Charger les états de commande avec les relations associées
        $order_status = OrderStatusActor::with(['quotation', 'user'])
            ->where('order_id', $id)
            ->orderBy('order_status')
            ->get()
            ->map(function ($status) {
                return [
                    'user_id' => $status->user->id,
                    'firstname' => $status->user->firstname,
                    'lastname' => $status->user->lastname,
                    'usertype' => $status->user->usertype,
                    'number_n' => $status->user->number_n,
                    'current_status' => $status->quotation->status,
                    'policy_number' => $status->quotation->policy_number,
                    'order_id' => $status->order_id,
                    'order_status' => $status->order_status,
                    'created_at' => $status->created_at,
                    'updated_at' => $status->updated_at,
                ];
            });
    
        return view('Backoffice.backend/order/order-timeline')->with([
            'isActive' => 'commande',
            'order_status' => $order_status,
        ]);
    }
        
    

    public function loadDevisPDF($comp_id, $quote_id)
    {
        $prospect = DB::table('quotation')
            ->join('assurance_auto_infos', 'assurance_auto_infos.id', '=', 'quotation.assurance_infos_id')
            ->join('auto_infos', 'auto_infos.id', '=', 'quotation.product_id')
            ->join('users', 'users.id', '=', 'quotation.user_id')
            ->join('make', 'make.id', '=', 'auto_infos.make_id')
            ->join('auto_categories', 'auto_categories.id', '=', 'auto_infos.category')
            ->join('city', 'city.id', '=', 'auto_infos.parkingzone')
            ->join('periode', 'periode.id', '=', 'assurance_auto_infos.periode')
            ->join('job', 'job.id', '=', 'users.job_id')
            ->where('quotation.id', $quote_id)
            ->select(
                'number_n', 'policy_number', 'firstname', 'lastname', 'email', 'contact', 'usertype', 'product_type',
                'matriculation', 'power', 'energy', 'firstrelease', 'placesnumber', 'city.zone', 'vneuve', 'vvenale',
                'charge_utile', 'color', 'reduction_commerciale', 'assurance_auto_infos.releasedate as assurance_release_date',
                'assurance_auto_infos.id as assurance_auto_info_id', 'periode.periode', 'periode.nbmois', 'periode.id as pid',
                'subscription_type', 'city.id as cid', 'quotation.status', 'quotation.company_id as id_comp',
                'quotation.id as qid', 'quotation.collect_data', 'quotation.created_at', 'make.id as makid',
                'auto_categories.id as autid', 'make.title', 'auto_categories.categorie', 'auto_categories.shortdesc',
                'auto_infos.id as auto_info_id', 'users.id as uid', 'guarante', 'job.id as jid', 'jobtitle',
                'discount as job_discount', 'date_pc', 'proprio_veh', 'company_name'
            )
            ->first();
    
        if (!$prospect) {
            Session::flash('error', 'Une erreur s\'est produite');
            return redirect()->back();
        }
    
        // Calculer ou récupérer les données de collecte
        if (is_null($prospect->collect_data)) {
            $quotationsData = app('App\Http\Controllers\Quotation\AutoQuotationController')
                ->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id);
            
            $quotations = json_decode($quotationsData);
            DB::table('quotation')->where('id', $quote_id)->update([
                'collect_data' => $quotationsData
            ]);
        } else {
            $quotations = json_decode($prospect->collect_data);
        }
    
        // Sélectionner les données du devis
        $data = collect($quotations)->firstWhere('idcomp', $comp_id);
        if (!$data) {
            Session::flash('error', 'Devis non trouvé pour la compagnie spécifiée');
            return redirect()->back();
        }
    
        // Récupérer les informations de la compagnie
        $company_quotation = DB::table('auto_companyquotation')
            ->where(['companyid' => $data->idcomp, 'type_assurance' => 1])
            ->orderBy('id', 'desc')
            ->first();
    
        if (!$company_quotation) {
            Session::flash('error', 'Informations de la compagnie introuvables');
            return redirect()->back();
        }
    
        $comp_gar = json_decode($company_quotation->formules, true);
        $garantees = DB::table('auto_guarantee')->get();
    
        // Générer le PDF
        $pdf = PDF::loadView('app.pdf.auto.invoice', compact('data', 'prospect', 'garantees', 'comp_gar'));
        return $pdf->stream();
    }

    public function loadDevisVoyagePDF($comp_id,$quote_id)
    {
      $prospect =  DB::table("quotation")
                ->join("users","users.id","quotation.user_id")
                ->join("assurance_voyage_infos","assurance_voyage_infos.id","quotation.assurance_infos_id")
                ->join("pays","pays.pays_id","assurance_voyage_infos.destination_country")
                ->select("users.*","quotation.id as quote_id","quotation.assurance_infos_id","quotation.number_n","collect_data","quotation.user_id","quotation.product_type","quotation.company_id","quotation.created_at as date_devis", "quotation.status as status_devis","assurance_voyage_infos.id as assur_voy_id","destination_country","current_addr","destination_addr","departure_date","arrival_date","nationality_id","passport_num","date_expire_passport","pays.pays_name","pays.pays_code","pays.pays_zone")
                ->where("quotation.id",$quote_id)->get();
      
      if(sizeof($prospect)>0){
        
        $prospect = $prospect[0];

          if($prospect->collect_data==null){
              $quotations = json_decode(app('App\Http\Controllers\Quotation\VoyageQuotationController')->caculVoyageQuotationFromDb($prospect));
              DB::table("quotation")->where("id",$id)->update([
                  "collect_data"=> app('App\Http\Controllers\Quotation\VoyageQuotationController')->caculVoyageQuotationFromDb($prospect)
              ]);
          }
          else{
              $quotations = json_decode($prospect->collect_data);
          }
        if($quotations){
          foreach ($quotations as $q) {
            if($q->idcomp==$comp_id){
              $data = $q;
           }
          }
        }

        $company_quotation = DB::table('auto_companyquotation')->where(['companyid'=>$data->idcomp,'type_assurance'=>3])->orderBy('id','desc')->first();
        if($company_quotation)
          $comp_gar = json_decode($company_quotation->formules, true);
        else 
          return redirect()->back();
        
        $pdf1 = PDF::loadView('app.pdf.voyage.invoice', compact('data','prospect','comp_gar'));
        
        return $pdf1->stream();    
      }

      else{
        Session::flash('error','Oups! Une erreur s\'est produite');
        return redirect()->back();
      }
    }



    public function setAllAutoQuotationToPersistedData(){
        $quotes = DB::table("quotation")->where('product_type',1)->orderBy('id','desc')->get();       	
	        foreach ($quotes as $q){

	            if($q->collect_data==null){
	                $prospect = DB::select('SELECT 
	                number_n,
	                priority,
	                policy_number,
	                firstname,
	                lastname,
	                email,
	                contact,
	                gender,
	                dob,
	                usertype,
	                product_type,
	                matriculation,
	                power,
	                proprio_veh,
	                company_name,
	                manager_name,
	                name_cg,
	                energy,
	                firstrelease,
	                placesnumber,
	                parkingzone,
	                city.zone,
	                type_id,
	                vneuve,
	                vvenale,
	                city,
	                city.zone,
	                charge_utile,
	                color,
	                reduction_commerciale,
	                assurance_auto_infos.releasedate as assurance_release_date,
	                assurance_auto_infos.id as assurance_auto_info_id,
	                periode.periode,
	                periode.nbmois,
	                periode.id as pid,
	                subscription_type,
	                city.id as cid,
	                quotation.status,
	                quotation.company_id as id_comp,
	                quotation.id as qid,
	                quotation.phone_client,
	                quotation.delivery_location,
	                quotation.renew_order,
	                quotation.collect_data,
	                quotation.created_at as created_at,
	                make.id as makid,
	                quotation.id as qid,
	                auto_categories.id as autid,
	                make.title,
	                auto_categories.categorie,
	                auto_categories.shortdesc,
	                auto_infos.id as auto_info_id,
	                users.id as uid,
	                guarante,
	                job.id as jid,
	                jobtitle,
	                discount as job_discount,
	                job_id,
	                auto_infos.type_id,
	                date_pc,
	                proprio_veh,
	                company_name
	                from 
	                quotation,
	                assurance_auto_infos,
	                auto_infos,
	                users,
	                make,
	                auto_categories,
	                city,
	                periode,
	                job,
	                car_type
	                where users.id=user_id and auto_infos.id=product_id and quotation.id="'.$q->id.'" and  assurance_auto_infos.id=assurance_infos_id and job.id=job_id and car_type.id_type=auto_infos.type_id and make.id=auto_infos.make_id and auto_categories.id=auto_infos.category and city.id=auto_infos.parkingzone and periode.id=assurance_auto_infos.periode');
                 
                  if(sizeof($prospect)>0){
                    $prospect = $prospect[0];
  	                DB::table("quotation")->where("id",$q->id)->update([
                        "collect_data"=> app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id)
  	                ]);
                  } 
	            }
	        }
    }

    public function setAllTravelQuotationToPersistedData()
    {
         DB::table("quotation")->where('product_type',3)->orderBy('id','desc')->chunk(100,function ($quotes){      	
	        foreach ($quotes as $q) {

	            if ($q->collect_data == null) {
	                $prospect = DB::table("quotation")
	                    ->join("users", "users.id", "quotation.user_id")
	                    ->join("assurance_voyage_infos", "assurance_voyage_infos.id", "quotation.assurance_infos_id")
	                    ->join("pays", "pays.pays_id", "assurance_voyage_infos.destination_country")
	                    ->select("users.*", "quotation.id as quote_id", "quotation.assurance_infos_id","collect_data","user_id", "quotation.number_n", "collect_data", "quotation.user_id", "quotation.product_type", "quotation.company_id", "quotation.created_at as date_devis", "quotation.status as status_devis", "assurance_voyage_infos.id as assur_voy_id", "destination_country", "current_addr", "destination_addr", "departure_date", "arrival_date", "nationality_id", "passport_num", "date_expire_passport", "pays.pays_name", "pays.pays_code", "pays.pays_zone")
	                    ->where("quotation.id", $q->id)->first();

	                DB::table("quotation")->where("id", $q->id)->update([
	                    "collect_data" => app('App\Http\Controllers\Quotation\VoyageQuotationController')->caculVoyageQuotationFromDb($prospect)
	                ]);
	            }
	        }
         });
    }
    
}
