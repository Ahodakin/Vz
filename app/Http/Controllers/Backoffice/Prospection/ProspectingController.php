<?php

namespace App\Http\Controllers\Backoffice\Prospection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Make;
use App\Models\autoCategories;
use App\Models\City;
use App\Models\Job;
use App\Models\Periode;
use App\Models\Backoffice\autoGuarantee;
use App\Models\Backoffice\autoInfos;
use App\Models\Backoffice\autoCompany;
use App\Models\Backoffice\OptionnalService;
use App\Models\User;
use App\Models\Backoffice\assuranceAutoInfos;
use App\Models\assuranceVoyageInfos;
use App\Models\Backoffice\Quotation;
use App\Models\Backoffice\CarType;
use App\Models\Backoffice\Sinistre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProspectingController extends Controller
{
    
    public function ShowCreateQuotationForm()
  	{
        $makes = make::where('isMoto',0)->get();
        $makes = make::where('isMoto',0)->get();

        $categories = autoCategories::where('enabled', 1)->get();
        $zones = City::all();
        $jobs = Job::where('enabled',1)->get();
        $periodes = Periode::all();
        $companies = autoCompany::where('enabled',1)->get();
        $guarantees = autoGuarantee::where('isDeprecated',0)->get();
        $optional_services = OptionnalService::where('product_type',1)->get();
        $car_types = CarType::where('car_type_status',1)->get();
  
      return view('Backoffice/backend/prospection/create-devis',compact('makes','categories','zones','jobs','periodes','companies','guarantees','optional_services','car_types'));  
  	}

    public function ShowCreateVoyageQuotationForm()
    {
      $companies = DB::table('auto_company')->where(['has_travel'=>1])->get();
      $pays = DB::table('pays')->get();
       $optional_service = DB::table('optional_service')->where(['product_type'=>3])->get();
      return view('Backoffice/backend/prospection/create-devis-voyage')->with([
        'isActive'=>'prospectmanager',
        'pays'=> $pays,
        'companies'=>$companies,
        'optional_service'=>$optional_service
        ]);
    }

    public function showListQuotationPage()
    {
        // Obtenir les devis avec les utilisateurs associés
        $prospects = Quotation::with('user')
            ->select('number_n', 'policy_number', 'priority', 'user_id', 'product_type', 'product_id', 'assurance_infos_id', 'status', 'id as qid', 'created_at as date_created')
            ->whereBetween('status', [1, 4])
            ->whereHas('user', function($query) {
                $query->where('usertype', '<>', 99);
            })
            ->orderBy('qid', 'desc')
            ->orderBy('priority', 'asc')
            ->get();
    
        // Obtenir les utilisateurs prospects
        $prospects_users = User::where('usertype', 0)
            ->where('status', '<>', '-1')
            ->get();
    
        // Obtenir les utilisateurs avec le nombre de devis
        $prospects_users_with_quotes = User::withCount('quotations')
            ->where('usertype', 0)
            ->where('status', '<>', -1)
            ->having('quotations_count', '<', 5)
            ->orderBy('id', 'desc')
            ->get();
    
        return view('Backoffice.backend.prospection.list-devis', compact('prospects', 'prospects_users', 'prospects_users_with_quotes'));
    }

    //   public function ShowCreateMotoQuotationForm()
    // {
  
    //   return view('Backoffice/backend/prospection/create-devis-moto');  
    // }

    public function ShowCreateMotoQuotationForm()
    {
    $makes = DB::table('make')
            ->where('isMoto',0)
            ->get();

    $categories = autoCategories::where('enabled', 1)->get();
    $zones = City::all();
    $jobs = Job::where('enabled',1)->get();
    $periodes = Periode::all();
    $companies = autoCompany::where('enabled',1)->get();
    $guarantees = autoGuarantee::where('isDeprecated',0)->get();
    $optional_services = OptionnalService::where('product_type',1)->get();
    $car_types = DB::table('car_type')->where('car_type_status',0)->get();

    return view('Backoffice/backend/prospection/create-devis-moto')->with([
    'isActive'=>'prospectmanager',
    'categories'=>$categories,
    'makes'=> $makes,
    'zones'=> $zones,
    'jobs'=> $jobs,
    'car_types'=> $car_types,
    'guarantees'=> $guarantees,
    'companies'=> $companies,
    'optional_services'=> $optional_services,
    'periodes'=> $periodes
    ]);  
    }



    public function ShowListAllQuotationPage()
    {
        // Récupérer tous les prospects avec les informations des utilisateurs associés
        $prospects = Quotation::with('user')
            ->select('number_n', 'policy_number', 'priority', 'user_id', 'product_type', 'status', 'assurance_infos_id', 'product_id', 'id as qid', 'created_at as date_created')
            ->orderBy('id', 'desc')
            ->get();

        // Récupérer les devis en commande (status entre 2 et 4)
        $devis_cmde = Quotation::with('user')
            ->select('number_n', 'policy_number', 'priority', 'user_id', 'product_type', 'status', 'assurance_infos_id', 'product_id', 'id as qid', 'created_at as date_created')
            ->where('status', '>=', 2)
            ->where('status', '<', 4)
            ->orderBy('id', 'desc')
            ->get();

        // Récupérer les utilisateurs de type prospect avec un status différent de -1
        $prospects_users = User::where([
            ['usertype', '=', 0],
            ['status', '<>', -1]
        ])->get();

        return view('Backoffice.backend.prospection/list-all-proposition', compact('prospects', 'prospects_users', 'devis_cmde'))
            ->with(['isActive' => 'prospectmanager']);
    }


    public function ShowSendSMSPage()
    {
      $last_sms = DB::table('sending_notification')->where("to_user",0)->orderBy('id','desc')->get();
      return view('Backoffice/backend/prospection/send-notification')->with([
      'isActive'=>'prospectmanager',
      'last_sms'=>$last_sms
      ]);
      // return view('Backoffice/backend/prospection/send-notification');
    }


    public function ShowListOrderWaitingDeliveryPage()
    {
        // Modify this query to retrieve the required 'prospects' data.
        $prospects = Quotation::with('user')
        ->where('status', 'waiting_delivery')
        ->orderBy('created_at', 'desc')
        ->get();
    
    
        // Fetch communes from the 'commune' table
        $communes = DB::table('commune')->get();
    
        // Fetch delivery tour data
        $delivery_tour = DB::table('delivery_tour')
            ->join('users', 'users.id', 'delivery_tour.deliveryman_id')
            ->select('delivery_tour.*', 'firstname', 'lastname')
            ->orderBy('id', 'desc')
            ->get();
    
        // Fetch delivery tour order data
        $delivery_tour_order = DB::table('delivery_tour_order')
            ->join('quotation', 'quotation.id', 'delivery_tour_order.order_id')
            ->join('users', 'users.id', 'quotation.user_id')
            ->select('delivery_tour_order.*', 'quotation.number_n', 'quotation.policy_number', 'quotation.status', 'users.firstname', 'users.lastname')
            ->get();
    
        // Fetch admin users
        $adminUsers = User::where('usertype', 99)->where('status', 1)->get();
    
        // Pass data to the view
        return view('Backoffice/backend/order/waiting-delivery', compact('prospects', 'communes', 'adminUsers', 'delivery_tour', 'delivery_tour_order'))
            ->with(['isActive' => 'commande']);
    }

    public function ShowListOrderPage()
    {
      $prospects = DB::table('quotation')
                  ->join('users','users.id','quotation.user_id')
                  ->select('number_n','policy_number','priority','firstname','lastname','contact','email','usertype','product_type','quotation.status','assurance_infos_id','product_id','quotation.id as qid','quotation.created_at as date_created')
                  ->where('quotation.status','>=',3)->orderBy('quotation.id','desc')->get();
                  
      return view('Backoffice/backend/order/list-orders', compact('prospects'))->with(['isActive'=> 'commande']);
    }
    

    // public function ShowListOrderPage()
    // {
    //   $prospects = DB::table('quotation')
    //               ->join('users','users.id','quotation.user_id')
    //               ->select('number_n','policy_number','priority','firstname','lastname','contact','email','usertype','product_type','quotation.status','assurance_infos_id','product_id','quotation.id as qid','quotation.created_at as date_created')
    //               ->where('quotation.status','>=',3)->orderBy('quotation.id','desc')->get();
                  
    //   return view('Backoffice/backend/order/list-orders', compact('prospects'))->with(['isActive'=> 'commande']);
    // }
    

    public function showSinistre()
    {
        // Récupérer les sinistres avec les informations du gestionnaire (sin_manager)
        $sinistres = Sinistre::with('sinManager')->orderBy('sin_id', 'desc')->get();
        
        return view('Backoffice.backend.prospection.sinistres', compact('sinistres'))->with('isActive', 'claimsmanager');
    }
    
    
    public function detailsSinistre($sin_id)
    {
      $sinistre = DB::table('sinistre')->where('sin_id',$sin_id)->first();
      $logs_sinistre = DB::table('sinistre_status_log')->where('sinistre_id',$sin_id)->orderBy('id_log','desc')->get();
      if($sinistre)
        return view('Backoffice.backend.prospection.details-sinistre', compact('sinistre','logs_sinistre'))->with('isActive','claimsmanager');
      else
        return redirect()->back();
    }
    
    public function postDetailsSinistre(Request $req)
    {
      DB::table("sinistre")->where("sin_id",$req->sin_id)->update([
        'sin_status'=>$req->status_sin,
        'observation'=>$req->obs_sin,
        'updated_at'=>Carbon::now()
      ]);
  
      DB::table('sinistre_status_log')->insert([
          'sinistre_id'=>$req->sin_id,
          'id_user'=>Auth::user()->id,
          'status'=>$req->status_sin,
          'created_at'=>Carbon::now(),
          'updated_at'=>Carbon::now()
        ]);
  
      Session::flash("success","Status du sinistre mis à jour avec succès");
        return redirect()->back();
    }

    public function postDetailsSinistreDecision(Request $req)
    {
      DB::table("sinistre")->where("sin_id",$req->sin_id)->update([
        'decision_sin'=>$req->decision,
        'updated_at'=>Carbon::now()
      ]);
  
      Session::flash("success","Sinistre décidé");
      return redirect()->back();
    }

    public function newSinistre()
    {
      $active_order = getActiveAutoOrders();
      return view('Backoffice.backend.prospection.new-sinistre', compact('active_order'))->with('isActive','claimsmanager');
    }

    public function postSinistre(Request $req)
    {
        $sinistre_unique_number = $this->get_sinistre_unique_number();
        
        $id = DB::table('sinistre')->insertGetId([
            'sin_number'=> $sinistre_unique_number,
            'sin_manager'=> Auth::user()->id,
            'client_name'=> $req->name_client,
            'client_phone'=> $req->num_client,
            'client_policy_number'=> $req->num_police,
            'client_declaration'=> $req->declaration,
            'date_sinistre'=> Carbon::createFromFormat("d/m/Y", $req->sinistredate)->toDateString(),
            'sin_status'=>0,
            'decision_sin'=>0,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
  
        DB::table('sinistre_status_log')->insert([
          'sinistre_id'=>$id,
          'id_user'=>Auth::user()->id,
          'status'=>0,
          'created_at'=>Carbon::now(),
          'updated_at'=>Carbon::now()
        ]);
  
        $this->sendSinistreSMS($req->num_client,$sinistre_unique_number);
        Session::flash("success","Le N° de sinistre est le <b>$sinistre_unique_number</b>.");
        return redirect()->back();
    }

    public function deleteOrderToDeliverytour($id_order)
    {
      DB::table("delivery_tour_order")->where("order_id",$id_order)->delete();
      return redirect()->back();
    }

  

    public function CreateAutoQuotation(Request $request)
    {
        $auto = $this->saveCarIfNotExist2($request);

        $user = $this->saveUserIfNotExist2($request);

        $name = Session::get('_name_sousc');
        $phone = Session::get('_phone_sousc');

        $type = $request->get('souscription');
        $my_guaranties = $request->get('guarantee');
        $formule = $request->get('formule');
        $pref_comp = $request->get('pref_comp');
        $garantie= $this->format_garantie($type,$my_guaranties,$formule);
        $service= $this->format_service($request->get('opt_serv'));
        $priseeffet = Carbon::createFromFormat("d/m/Y", $request->get('priseeffet'))->toDateString();
        
        $assurance_infos = $this->saveInfoAutoInsurance($garantie, $priseeffet, $request->get('periode'), $request->get('souscription'));
        
        $quotation = $this->saveProductQuotation($auto->id,$assurance_infos->id,$user->id,1,$pref_comp,$service);

        $this->saveOrderStatusActor($quotation);

        $space_account_id = $this->saveSpacePersoAccountInfo($name,$phone);
        $this->storeWhoMadeQuote($quotation->id,$space_account_id);

        return redirect()->route('devis.details', ['id' => $quotation->id,'aid'=>$assurance_infos->id]);    
    }

    public function traitMotoQuotation(Request $request)
    {
          $auto = $this->saveMotoIfNotExist2($request);
          $user = $this->saveUserIfNotExist2($request);

          $name = Session::get('_name_sousc');
          $phone = Session::get('_phone_sousc');

        $type = $request->get('souscription');
        $my_guaranties = $request->get('guarantee');
        $formule = $request->get('formule');
        $pref_comp = $request->get('pref_comp');
        $garantie= $this->format_garantie($type,$my_guaranties,$formule);
        $service= $this->format_service($request->get('opt_serv'));
        $priseeffet = Carbon::createFromFormat("d/m/Y", $request->get('priseeffet'))->toDateString();
        
        $assurance_infos = $this->saveInfoAutoInsurance($garantie, $priseeffet, $request->get('periode'), $request->get('souscription'));
        //dd($auto);
        $quotation = $this->saveProductQuotation($auto->id,$assurance_infos->id,$user->id,1,$pref_comp,$service);

        $this->saveOrderStatusActor($quotation);

        $space_account_id = $this->saveSpacePersoAccountInfo($name,$phone);
        $this->storeWhoMadeQuote($quotation->id,$space_account_id);

        return redirect()->route('devis.details', ['id' => $quotation->id,'aid'=>$assurance_infos->id]);     
    }

    public function traitVoyageQuotation(Request $request)
    {
      $user = $this->saveUserIfNotExist2($request);

      $name = Session::get('_name_sousc');
      $phone = Session::get('_phone_sousc');

      $assurance_infos = $this->saveInfoVoyageInsurance($request);
      $service=($request->get('opt_serv')!=null) ? $this->format_service($request->get('opt_serv')) : "[]";
      $quotation = $this->saveProductQuotation(0,$assurance_infos->id,$user->id,3,$request->pref_comp,$service);
      $this->saveOrderStatusActor($quotation); 
      $space_account_id = $this->saveSpacePersoAccountInfo($name,$phone);
      $this->storeWhoMadeQuote($quotation->id,$space_account_id);
      
      return redirect()->route('devis.voyage.details', ['id' => $quotation->id,'aid'=>$assurance_infos->id]); 
    }

    private function saveSpacePersoAccountInfo($souscr_name,$souscr_phone)
    {
        if(!$this->checkIfPersoSpaceExist($souscr_phone)){
            $password = str_random(6);
            Session::put('_password_sousc', $password);
            return DB::table("espace_perso_account")->insertGetId([
                'name' => $souscr_name,
                'phone_number' =>  $souscr_phone,
                'password' => bcrypt($password),
                'status' => 0,
                'remember_token'=>str_random(60),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
        }else{
            $space_account = DB::table("espace_perso_account")->where("phone_number",$souscr_phone)->first();
            return $space_account->id;
        }
    }

    public function sendSinistreSMS($phone,$number)
    {
      $mon_sms = rawurlencode("VOUS POUVEZ SUIVRE VOTRE SINISTRE AVEC LE N°$number.\nLES DOCUMENTS A FOURNIR SONT LE CONSTAT AMIABLE ET VOTRE DECLARATION.");
      $sender_id = rawurlencode("220 170 00"); //Nombre de caractères inférieure à 11 (y compris les espaces)
      
      $phone = str_replace(" ", "", $phone);
      $phone = str_replace("-", "", $phone);
      if(strlen($phone)==8)
      $url = "http://gateway2.arolitec.com/interface/senderv2.php?user=addams&password=wN44vu5Q&sender=".$sender_id."&receiver=225".$phone."&content=".$mon_sms;
      else
      $url = "http://gateway2.arolitec.com/interface/senderv2.php?user=addams&password=wN44vu5Q&sender=".$sender_id."&receiver=".$phone."&content=".$mon_sms;
      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST =>"GET",
      CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache"
      ),
      ));
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) 
      {
      echo false;
      } 
      else 
      {
      echo true;
      }
    }

}
