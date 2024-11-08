<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str; // Importation de la classe Str
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
use App\Models\Role;
use App\Models\Permission;
use App\Models\assuranceAutoInfos;
use App\Models\assuranceVoyageInfos;
use App\Models\Quotation;
use PDF;
use Entrust;
use Snowfire\Beautymail\Beautymail;
use Illuminate\Support\Facades\DB;

class ProductPageController extends Controller
{
    public function showAutoPage()
    {
    	return view('app.frontend.page-automobile')->with(['active'=>'auto']);
    }

    public function showMotoPage()
    {
        return view('app.frontend.page-moto')->with(['active'=>'moto']);
    }

    public function showVoyagePage()
    {
        return view('app.frontend.page-voyage')->with(['active'=>'voyage']);
    }

    public function showHabitationPage()
    {
        return view('app.frontend.page-habitation')->with(['active'=>'habitation']);
    }

     public function showSinistrePage()
    {
        return view('app.frontend.page-sinistre')->with(['active'=>'sinistre']);
    }

    public function showAutoQuotationPage()
    {
        if(Auth::guard('space_perso')->check()) return redirect()->route('page.myspace.devis-auto');
    	$categories = DB::table('auto_categories')->where('enabled',1)->get();
        $companies = DB::table('auto_company')->where('enabled',1)->get();
        $makes = DB::table('make')
            ->where('isMoto',0)
            ->get();
        $zones = DB::table('city')->get();
        $jobs = DB::table('job')->where('enabled',1)->orderBy('jobtitle')->get();
        $car_types = DB::table('car_type')->where('car_type_status',1)->get();
        $guarantee = DB::table('auto_guarantee')->where('isdeprecated',0)->get();
        $periode = DB::table('periode')->get();
        $optional_service = DB::table('optional_service')->where(['product_type'=>1])->get();

    	return view('app.frontend.page-quotation-automobile')->with([
    		'active'=>'auto',
            'user_car'=>null,
            'categories'=>$categories,
            'makes'=> $makes,
            'zones'=> $zones,
            'car_types'=> $car_types,
            'jobs'=> $jobs,
            'guarantee'=> $guarantee,
            'periode'=> $periode,
            'companies'=>$companies,
            'optional_service'=> $optional_service
    	]);
    }

    public function showMotoQuotationPage()
    {
        if(Auth::guard('space_perso')->check()) return redirect()->route('page.myspace.devis-moto');
        $categories = DB::table('auto_categories')->where('enabled',1)->get();
        $companies = DB::table('auto_company')->where('enabled',1)->get();
        $makes = DB::table('make')
            ->join('model','make.id','=','model.make_id')
            ->select('make.*','model.id as modid','model.title as modtitle')
            ->get();
        $zones = DB::table('city')->get();
        $jobs = DB::table('job')->where('enabled',1)->orderBy('jobtitle')->get();
        $car_types = DB::table('car_type')->where('car_type_status',0)->get();
        $guarantee = DB::table('auto_guarantee')->where('isdeprecated',0)->get();
        $periode = DB::table('periode')->get();
        $optional_service = DB::table('optional_service')->where(['product_type'=>1])->get();



        return view('app.frontend.page-quotation-moto')->with([
            'active'=>'moto',
            'user_car'=>null,
            'categories'=>$categories,
            'makes'=> $makes,
            'zones'=> $zones,
            'car_types'=> $car_types,
            'jobs'=> $jobs,
            'guarantee'=> $guarantee,
            'periode'=> $periode,
            'companies'=>$companies,
            'optional_service'=> $optional_service
        ]);
    }

    public function showVoyageQuotationPage()
    {
        if(Auth::guard('space_perso')->check()) return redirect()->route('page.myspace.devis-voyage');
        $companies = DB::table('auto_company')->where(['has_travel'=>1])->get();
        $pays = DB::table('pays')->get();
        $optional_service = DB::table('optional_service')->where(['product_type'=>3])->get();



        return view('app.frontend.page-quotation-voyage')->with([
            'active'=>'voyage',
            'pays'=> $pays,
            'companies'=>$companies,
            'optional_service'=> $optional_service
        ]);
    }

    public function showQuoteDetails($quote_id,$comp_id)
    {
        $prospect = DB::select('SELECT
        number_n,
        policy_number,
        firstname,
        lastname,
        email,
        contact,
        usertype,
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
        quotation.collect_data,
        quotation.company_id as id_comp,
        quotation.id as qid,
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
        date_pc,
        city.zone,
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
        job
        where users.id=user_id and auto_infos.id=product_id and quotation.id="'.$quote_id.'" and  assurance_auto_infos.id=assurance_infos_id and job.id=job_id and make.id=auto_infos.make_id and auto_categories.id=auto_infos.category and city.id=auto_infos.parkingzone and periode.id=assurance_auto_infos.periode');

        if(sizeof($prospect)>0){
          $prospect = $prospect[0];

          if($prospect->collect_data==null){
              $quotations = json_decode(app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id));
              DB::table("quotation")->where("id",$quote_id)->update([
                  "collect_data"=> app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id)
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


          $company_quotation = DB::table('auto_companyquotation')->where(['companyid'=>$data->idcomp,'type_assurance'=>1])->orderBy('id','desc')->first();
          if($company_quotation)
            $comp_gar = json_decode($company_quotation->formules, true);
          else
            return redirect()->back();

          $garantees = DB::table('auto_guarantee')->get();



          return view('app.frontend.details-auto-quote', compact('data','prospect','garantees','comp_gar'))->with('active','auto');
        }
    }

    public function showDevisAllResult($quote_id)
    {
        $prospect = DB::select('SELECT
        number_n,
        policy_number,
        firstname,
        lastname,
        email,
        contact,
        usertype,
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
        quotation.collect_data,
        quotation.company_id as id_comp,
        quotation.id as qid,
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
        date_pc,
        city.zone,
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
        job
        where users.id=user_id and auto_infos.id=product_id and quotation.id="'.$quote_id.'" and  assurance_auto_infos.id=assurance_infos_id and job.id=job_id and make.id=auto_infos.make_id and auto_categories.id=auto_infos.category and city.id=auto_infos.parkingzone and periode.id=assurance_auto_infos.periode');

        if(sizeof($prospect)>0){
          $prospect = $prospect[0];

          if($prospect->collect_data==null){
              $quotations = json_decode(app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id));
              DB::table("quotation")->where("id",$quote_id)->update([
                  "collect_data"=> app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id)
              ]);
          }
          else{
              $quotations = json_decode($prospect->collect_data);
          }

        }
        else{
            return redirect()->back();
        }
        $periodes = Periode::all();
        //dd($prospect);
        return view('app.frontend.all-auto-quote', compact("prospect","quotations","periodes"))->with('active','auto');
    }

    public function updateAutoFormule(Request $req)
    {
        /*DB::table('assurance_auto_infos')->update([
            'guarante'=>$req->formule,
            'releasedate'=>Carbon::createFromFormat("d/m/Y", $req->priseeffet)->toDateString(),
            'periode'=>$req->periode
        ]);*/
        Session::flash('success','Assurance modifiée avec succès');
        return redirect()->back();
    }

    public function showTravelQuoteDetails($quote_id,$comp_id)
    {

        $prospect =  DB::table("quotation")
                  ->join("users","users.id","quotation.user_id")
                  ->join("assurance_voyage_infos","assurance_voyage_infos.id","quotation.assurance_infos_id")
                  ->join("pays","pays.pays_id","assurance_voyage_infos.destination_country")
                  ->select("users.*","quotation.id as quote_id","quotation.assurance_infos_id","quotation.number_n","quotation.user_id","quotation.product_type","quotation.company_id","quotation.created_at as date_devis", "quotation.status as status_devis","collect_data","assurance_voyage_infos.id as assur_voy_id","destination_country","current_addr","destination_addr","departure_date","arrival_date","nationality_id","passport_num","date_expire_passport","pays.pays_name","pays.pays_code","pays.pays_zone")
                  ->where("quotation.id",$quote_id)->get();


       if(sizeof($prospect)>0){
         $prospect = $prospect[0];

         if($prospect->collect_data==null){
              $quotations = json_decode(app('App\Http\Controllers\Quotation\VoyageQuotationController')->caculVoyageQuotationFromDb($prospect));
              DB::table("quotation")->where("id",$quote_id)->update([
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


       //dd($prospect);


         return view('app.frontend.details-voyage-quote', compact('data','prospect','comp_gar'))->with('active','voyage');
       }
       else{
        Session::flash('error','Oups! Une erreur s\'est produite');
        return redirect()->back();
      }
    }

    public function loadDevisPDF($comp_id,$quote_id)
    {
      $prospect = DB::select('SELECT
        number_n,
        policy_number,
        firstname,
        lastname,
        email,
        contact,
        usertype,
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
        quotation.collect_data,
        quotation.company_id as id_comp,
        quotation.id as qid,
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
        date_pc,
        city.zone,
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
        job
        where users.id=user_id and auto_infos.id=product_id and quotation.id="'.$quote_id.'" and  assurance_auto_infos.id=assurance_infos_id and job.id=job_id and make.id=auto_infos.make_id and auto_categories.id=auto_infos.category and city.id=auto_infos.parkingzone and periode.id=assurance_auto_infos.periode');

      if(sizeof($prospect)>0){
        $prospect = $prospect[0];

        if($prospect->collect_data==null){
              $quotations = json_decode(app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id));
              DB::table("quotation")->where("id",$quote_id)->update([
                  "collect_data"=> app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id)
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

        $company_quotation = DB::table('auto_companyquotation')->where(['companyid'=>$data->idcomp,'type_assurance'=>1])->orderBy('id','desc')->first();
        if($company_quotation)
          $comp_gar = json_decode($company_quotation->formules, true);
        else
          return redirect()->back();

        $garantees = DB::table('auto_guarantee')->get();


        $pdf1 = PDF::loadView('app.pdf.auto.invoice', compact('data','prospect','garantees','comp_gar'));

        return $pdf1->stream();
      }

      else{
        Session::flash('error','Oups! Une erreur s\'est produite');
        return redirect()->back();
      }
    }

    public function loadContratPDF($comp_id,$quote_id)
    {
      $prospect = DB::select('SELECT
        number_n,
        policy_number,
        firstname,
        lastname,
        email,
        contact,
        usertype,
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
        quotation.collect_data,
        quotation.company_id as id_comp,
        quotation.id as qid,
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
        date_pc,
        city.zone,
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
        job
        where users.id=user_id and auto_infos.id=product_id and quotation.id="'.$quote_id.'" and  assurance_auto_infos.id=assurance_infos_id and job.id=job_id and make.id=auto_infos.make_id and auto_categories.id=auto_infos.category and city.id=auto_infos.parkingzone and periode.id=assurance_auto_infos.periode');

      if(sizeof($prospect)>0){
        $prospect = $prospect[0];

        if($prospect->collect_data==null){
            $quotations = json_decode(app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id));
            DB::table("quotation")->where("id",$quote_id)->update([
                "collect_data"=> app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id)
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

        $company_quotation = DB::table('auto_companyquotation')->where(['companyid'=>$data->idcomp,'type_assurance'=>1])->orderBy('id','desc')->first();
        if($company_quotation)
          $comp_gar = json_decode($company_quotation->formules, true);
        else
          return redirect()->back();

        $garantees = DB::table('auto_guarantee')->get();


        $pdf1 = PDF::loadView('app.pdf.auto.contrat-service', compact('data','prospect','garantees','comp_gar'));
        $pdf1->output();
        $dom_pdf = $pdf1->getDomPDF();

        $canvas = $dom_pdf ->get_canvas();

        $canvas->page_text($canvas->get_width()-45, $canvas->get_height()-35, "{PAGE_NUM}/{PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf1->stream();
      }

      else{
        Session::flash('error','Oups! Une erreur s\'est produite');
        return redirect()->back();
      }
    }

    public function loadDevisVoyagePDF($comp_id,$quote_id)
    {
      $prospect =  DB::table("quotation")
                ->join("users","users.id","quotation.user_id")
                ->join("assurance_voyage_infos","assurance_voyage_infos.id","quotation.assurance_infos_id")
                ->join("pays","pays.pays_id","assurance_voyage_infos.destination_country")
                ->select("users.*","quotation.id as quote_id","quotation.assurance_infos_id","quotation.number_n","quotation.user_id","quotation.product_type","quotation.company_id","quotation.created_at as date_devis","collect_data", "quotation.status as status_devis","assurance_voyage_infos.id as assur_voy_id","destination_country","current_addr","destination_addr","departure_date","arrival_date","nationality_id","passport_num","date_expire_passport","pays.pays_name","pays.pays_code","pays.pays_zone")
                ->where("quotation.id",$quote_id)->get();

      if(sizeof($prospect)>0){

        $prospect = $prospect[0];

        if($prospect->collect_data==null){
              $quotations = json_decode(app('App\Http\Controllers\Quotation\VoyageQuotationController')->caculVoyageQuotationFromDb($prospect));
              DB::table("quotation")->where("id",$quote_id)->update([
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

    public function traitAutoQuotation(Request $request)
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

        return $this->AutoQuoteDetail($quotation->id,$assurance_infos->id);
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
        return $this->AutoQuoteDetail($quotation->id,$assurance_infos->id);
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
        return $this->VoyageQuoteDetail($quotation->id,$assurance_infos->id);

    }

public function AutoQuoteDetail($id,$aid)
{
    $prospect = DB::select('SELECT
    number_n,
    firstname,
    lastname,
    email,
    contact,
    usertype,
    job_id,
    date_pc,
    proprio_veh,
    company_name,
    product_type,
    matriculation,
    power,
    energy,
    charge_utile,
    color,
    firstrelease,
    placesnumber,
    parkingzone,
    vneuve,
    vvenale,
    city,
    city.zone,
    reduction_commerciale,
    job.id as jid,
    jobtitle,
    discount as job_discount,
    assurance_auto_infos.releasedate as assurance_release_date,
    assurance_auto_infos.id as assurance_auto_info_id,
    periode.periode,
    periode.nbmois,
    periode.id as pid,
    subscription_type,
    city.id as cid,
    quotation.status,
    quotation.collect_data,
    quotation.company_id as id_comp,
    quotation.id as qid,
    quotation.created_at as created_at,
    make.id as makid,
    quotation.id as qid,
    quotation.delivery_location,
    quotation.phone_client,
    auto_categories.id as autid,
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
    make,
    auto_categories,
    city,
    periode,
    job
    where users.id=user_id and auto_infos.id=product_id and quotation.id="'.$id.'" and  assurance_auto_infos.id=assurance_infos_id and job.id=job_id and make.id=auto_infos.make_id and auto_categories.id=auto_infos.category and city.id=auto_infos.parkingzone and periode.id=assurance_auto_infos.periode')[0];



    Session::put('_userid_', $prospect->uid);
    Session::put('_firstname_', $prospect->firstname);
    Session::put('_lastname_', $prospect->lastname);
    Session::put('_email_', $prospect->email);
    Session::put('_contact_', $prospect->contact);
    Session::put('_quoteNumber_', $prospect->number_n);

    $makes = DB::table('make')
    ->join('model','make.id','=','model.make_id')
    ->select('make.*','model.id as modid','model.title as modtitle')
    ->get();
    $categories = autoCategories::where('enabled', 1)->get();
    $zones = City::all();
    $jobs = Job::all();
    $periodes = Periode::all();
    $guarantees = autoGuarantee::all();
    $guaranty = assuranceAutoInfos::find($aid);
    if($guaranty && $prospect){
    $guarantees_array = $this->garantie_to_array($guaranty->guarante);
    }
    else{
      Session::flash('error','Une erreur s\'est produit');
      return redirect()->route('page.auto')->with(['isActive'=>'auto']);
    }
    if($prospect->collect_data==null){
        $quotations = json_decode(app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id));
        DB::table("quotation")->where("id",$id)->update([
            "collect_data"=> app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($prospect->auto_info_id, $prospect->uid, $prospect->assurance_auto_info_id)
        ]);
    }
    else{
        $quotations = json_decode($prospect->collect_data);
    }
    //dd($quotations);
    $optional_service = DB::table('optional_service')->where(['product_type'=>1])->get();
    $selected_serv = collect($quotations[0]->servopt);

    //$qu_sorted = collect($quotations)->sortBy("TTC");

   // return json_encode($qu_sorted->values()->all());
     return json_encode($quotations);
}

public function VoyageQuoteDetail($id)
{
  $prospect =  DB::table("quotation")
                ->join("users","users.id","quotation.user_id")
                ->join("assurance_voyage_infos","assurance_voyage_infos.id","quotation.assurance_infos_id")
                ->join("pays","pays.pays_id","assurance_voyage_infos.destination_country")
                ->select("users.*","quotation.id as quote_id","quotation.assurance_infos_id","quotation.number_n","quotation.user_id","quotation.product_type","quotation.company_id","assurance_voyage_infos.id as assur_voy_id","destination_country","current_addr","destination_addr","collect_data","departure_date","arrival_date","pays.pays_name","pays.pays_code","pays.pays_zone")
                ->where("quotation.id",$id)->first();

    Session::put('_userid_', $prospect->user_id);
    Session::put('_firstname_', $prospect->firstname);
    Session::put('_lastname_', $prospect->lastname);
    Session::put('_email_', $prospect->email);
    Session::put('_contact_', $prospect->contact);
    Session::put('_quoteNumber_', $prospect->number_n);
    if($prospect->collect_data==null){
         $quotations = json_decode(app('App\Http\Controllers\Quotation\VoyageQuotationController')->caculVoyageQuotationFromDb($prospect));
         DB::table("quotation")->where("id",$id)->update([
             "collect_data"=> app('App\Http\Controllers\Quotation\VoyageQuotationController')->caculVoyageQuotationFromDb($prospect)
         ]);
     }
     else{
         $quotations = json_decode($prospect->collect_data);
     }


    $qu_sorted = collect($quotations)->sortBy("PRIME");

    return json_encode($qu_sorted->values()->all());

}



public function ConfirmAutoQuotation(Request $request)
  {
    $qid = $request->get('qid');
    $q =  quotation::where('id', $qid)->first();
    $response = quotation::where('id', $qid)
        ->update([
          'status' =>1,
          'company_id' =>$request->get('comp_id'),
          'phone_client'=>$request->get('delivery_phone'),
          'delivery_location'=>$request->get('delivery_location')
          ]);

        $this->sendOrderSMS($request);
        $name = Session::get('_name_sousc');
        $phone = Session::get('_phone_sousc');
        $password = Session::get('_password_sousc');
        if(!Auth::guard('space_perso')->check()){
            if($password){
                $mon_sms = "CHER CLIENT, VOS ACCES DE CONNEXION A VOTRE ESPACE PERSO MONASSURANCE.CI SONT:\r\nLOGIN : (VOTRE NUMERO) \r\nMOT DE PASSE : $password \r\nACCEDEZ A VOTRE ESPACE POUR CONSULTER L'HISTORIQUE DE VOS DEVIS ET COMMANDE.";
                $this->sendSMSForAccountPassword($mon_sms,$phone);
                $p = str_replace(" ", "", $phone);
                DB::table('espace_perso_account')->where('phone_number', $p)->update([
                  'status'=>1
                ]);
            }else{
                $p = str_replace(" ", "", $phone);
                $acc = DB::table('espace_perso_account')->where('phone_number',$p)->first();
                if($acc){
                    $mon_sms = "CHER CLIENT, ACCEDEZ A VOTRE ESPACE POUR CONSULTER L'HISTORIQUE DE VOS DEVIS ET COMMANDE.\r\nLOGIN : $phone";
                    $this->sendSMSForAccountPassword($mon_sms,$p);
                }
            }
            Session::flush();
        }
        return json_encode($q->id);


  }

  private function storeWhoMadeQuote($quote_id,$space_account_id)
  {
       DB::table("made_quote")->insert([
            "quote_id"=>$quote_id,
            "account_id"=>$space_account_id,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ]);
  }

  public function sendOrderSMS($request)
  {
      // Message de confirmation de commande
      $mon_sms0 = rawurlencode("VOTRE COMMANDE A ETE ENREGISTREE AVEC SUCCES. UN CONSEILLER CLIENT VOUS CONTACTERA POUR CONFIRMER VOTRE COMMANDE.");
      
      // Message personnalisé
      $mon_sms1 = urlencode($request->hide_msg);
      
      // ID de l'expéditeur
      $sender_id = urlencode("220-170-00"); // Nombre de caractères inférieur à 11
      
      // Traitement du numéro de téléphone
      $phone = str_replace(" ", "", $request->delivery_phone); // Suppression des espaces
      $phone = str_replace("+225", "", $phone); // Suppression du préfixe international
      
      // Vérification de la longueur du numéro (10 chiffres)
      if(strlen($phone) == 10){
          $url0 = "http://gateway2.arolitec.com/interface/senderv2.php?user=addams&password=wN44vu5Q&sender=".$sender_id."&receiver=".$phone."&content=".$mon_sms0;
          $url1 = "http://gateway2.arolitec.com/interface/senderv2.php?user=addams&password=wN44vu5Q&sender=".$sender_id."&receiver=".$phone."&content=".$mon_sms1;
      } else {
          Session::flash('error', 'Numéro de téléphone invalide. Veuillez vérifier le numéro et réessayer.');
          return redirect()->back();
      }

      // Envoi du premier SMS (confirmation de commande)
      $curl0 = curl_init();
      curl_setopt_array($curl0, array(
          CURLOPT_URL => $url0,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
              "cache-control: no-cache"
          ),
      ));
      $response0 = curl_exec($curl0);
      $err0 = curl_error($curl0);
      curl_close($curl0);

      // Vérification d'erreur pour le premier SMS
      if ($err0) {
          Session::flash('error', 'Erreur lors de l\'envoi du premier SMS : ' . $err0);
      } else {
          Session::flash('success', 'Premier SMS envoyé avec succès.');
      }

      // Envoi du second SMS (message personnalisé)
      $curl1 = curl_init();
      curl_setopt_array($curl1, array(
          CURLOPT_URL => $url1,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
              "cache-control: no-cache"
          ),
      ));
      $response1 = curl_exec($curl1);
      $err1 = curl_error($curl1);
      curl_close($curl1);

      // Vérification d'erreur pour le second SMS
      if ($err1) {
          Session::flash('error', 'Erreur lors de l\'envoi du second SMS : ' . $err1);
      } else {
          Session::flash('success', 'Second SMS envoyé avec succès.');
      }
  }


  public function showAutoCongratePage($id_quote){

    $prospect = DB::select('SELECT
    number_n,
    firstname,
    lastname,
    email,
    contact,
    usertype,
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
    city.zone,
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
    quotation.created_at as created_at,
    make.id as makid,
    quotation.id as qid,
    quotation.delivery_location,
    quotation.phone_client,
    auto_categories.id as autid,
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
    make,
    auto_categories,
    city,
    periode
    where users.id=user_id and auto_infos.id=product_id and quotation.id="'.$id_quote.'" and  assurance_auto_infos.id=assurance_infos_id and make.id=auto_infos.make_id and auto_categories.id=auto_infos.category and city.id=auto_infos.parkingzone and periode.id=assurance_auto_infos.periode');
    if($prospect)
        return view('app.frontend.automobile-congrate')->with(['active'=>'','prospect'=>$prospect[0]]);
    else
        return abort(404);
  }

  public function showVoyageCongratePage($id_quote){

    $prospect =  DB::table("quotation")
                ->join("users","users.id","quotation.user_id")
                ->join("assurance_voyage_infos","assurance_voyage_infos.id","quotation.assurance_infos_id")
                ->join("pays","pays.pays_id","assurance_voyage_infos.destination_country")
                ->select("users.*","quotation.id as quote_id","quotation.assurance_infos_id","quotation.number_n","quotation.user_id","quotation.product_type","quotation.company_id","assurance_voyage_infos.id as assur_voy_id","destination_country","current_addr","destination_addr","departure_date","arrival_date","pays.pays_name","pays.pays_code","pays.pays_zone")
                ->where("quotation.id",$id_quote)->first();

    return view('app.frontend.voyage-congrate')->with(['active'=>'','prospect'=>$prospect]);
  }



//formatage des garanties
  private function format_garantie($type,$my_guaranties,$formule)
  {
    if($type=='F'){
      $garantie= $formule;
    }

    else{
    $nbre = count($my_guaranties);
    $garantie = "[";
    $delimiter = ",";
    for($i=0;$i<$nbre;$i++)
    {
    if($i==$nbre-1)
    {
    $delimiter = "";
    }
    $garantie =$garantie.$my_guaranties[$i].$delimiter;

    }
    $garantie =$garantie."]";
    }

    return $garantie;
  }

  private function garantie_to_array($guarantee)
  {
    $result = substr($guarantee, 1, -1);
    $guarantees_array = explode(',', $result);
    return $guarantees_array;
  }

    private function format_service($services)
    {
        // Vérifiez si $services est un tableau et non null
        if (is_array($services) && count($services) > 0) {
            $nbre = count($services);
            $service = "[";
            $delimiter = ",";

            for ($i = 0; $i < $nbre; $i++) {
                // Ajoutez votre logique ici
            }

            $service .= "]";
        } else {
            // Gérer le cas où $services est null ou vide
            $service = "[]"; // Retourne un tableau vide si $services est null ou vide
        }

        return $service;
    }



    private function saveCarIfNotExist2(Request $req)
      {
        $auto = new autoInfos();
        $auto->matriculation=strtoupper(str_replace(" ", "",$req->immat));
        $auto->proprio_veh = $req->proprio_veh;
        $auto->company_name = $req->company_name;
        $auto->manager_name = $req->manager_name;
        $auto->name_cg = $req->name_cg;
        $auto->make_id = $req->marque;
        $auto->type_id = $req->genre;
        $auto->category = $req->category;
        $auto->power = $req->puissance;
        $auto->charge_utile = $req->cu;
        $auto->energy = $req->ennergie;
        $auto->firstrelease = Carbon::createFromFormat("d/m/Y", $req->dateMiseCirc)->toDateString();
        $auto->vneuve = intval(str_replace(",", "", $req->vneuve));
        $auto->vvenale = intval(str_replace(",", "", $req->vvenale));
        $auto->color = $req->color;
        $auto->placesnumber  = $req->nbplace;
        $auto->parkingzone = $req->city;
        $auto->created_at = Carbon::now();
        $auto->updated_at = Carbon::now();
          if($auto->save()){
             return $auto;
          }
      }

      private function saveMotoIfNotExist2(Request $req)
      {
        $marque_id  = DB::table('make')->insertGetId([
            "code"=> strtoupper($req->marque),
            "title"=> strtoupper($req->marque),
            "isMoto"=> 1
        ]);
        $modele_id  = DB::table('model')->insertGetId([
            "make_id"=> $marque_id ,
            "code"=> strtoupper($req->marque."-".time()),
            "title"=> strtoupper($req->marque."-".time())
        ]);

        $vehicule = autoInfos::where('matriculation',strtoupper($req->immat))->first();
        $auto = new autoInfos();
        $auto->matriculation=strtoupper(str_replace(" ", "",$req->immat));
        $auto->proprio_veh = $req->proprio_veh;
        $auto->company_name = $req->company_name;
        $auto->manager_name = $req->manager_name;
        $auto->name_cg = $req->name_cg;
        $auto->make_id = $marque_id;
        $auto->type_id = 7;
        $auto->cylindree = $req->cylindree;
        $auto->category =5;
        $auto->power = 0;
        $auto->charge_utile = 0;
        $auto->energy = "E";
        $auto->firstrelease = Carbon::createFromFormat("d/m/Y", $req->dateMiseCirc)->toDateString();
        $auto->vneuve = intval(str_replace(",", "", $req->vneuve));
        $auto->vvenale = intval(str_replace(",", "", $req->vvenale));
        $auto->color = $req->color;
        $auto->placesnumber  = $req->nbplace;
        $auto->parkingzone = $req->city;
        $auto->created_at = Carbon::now();
        $auto->updated_at = Carbon::now();
          if($auto->save()){
             return $auto;
          }

      }


    private function saveUserIfNotExist2(Request $req)
    {
        //save client info
        $user_date_pc =($req->datePC!=null)? Carbon::createFromFormat("d/m/Y", $req->datePC)->toDateString() : null;
        $user_dob = ($req->dob!=null) ? Carbon::createFromFormat("d/m/Y", $req->dob)->toDateString() : null;
        $email = ($req->email=="")? time()."@email.com" : $req->email;
        if($req->proprio_veh!=null){
        $firstname = ($req->proprio_veh=="E") ? $req->company_name : $req->firstname;
        $lastname = ($req->proprio_veh=="E") ? $req->company_name : $req->lastname;
        $job_id = ($req->proprio_veh=="E") ? 13 : $req->job;
        }else{
            $firstname = $req->firstname;
            $lastname = $req->lastname;
            $job_id = 14;
        }
        if($req->proprio_veh=="P"){
            Session::put('_name_sousc', $firstname." ".$lastname);
            Session::put('_phone_sousc', str_replace(' ','',$req->phone));
        }else{
            Session::put('_name_sousc', $req->souscripteur_name);
            Session::put('_phone_sousc', str_replace(' ','',$req->phone_souscr));
        }

        $phone = str_replace(" ", "", $req->phone);
        $phone = str_replace("-", "", $req->phone);

        if(decrypt($req->get("_form_type_")) == 'AUTO'){
            if(User::check_auto_user($phone,$job_id) || User::check_mail($email))
            {
                $u = (User::check_auto_user($phone,$job_id)) ? User::check_auto_user($phone,$job_id) :User::check_mail($email);
                return $u;
            }else{

                $user =  new User();
                $user->firstname=$firstname;
                $user->lastname =$lastname;
                $user->contact=$phone;
                $user->email =$email;
                $user->gender =$req->gender;
                $user->job_id =$job_id;
                $user->date_pc = $user_date_pc;
                $user->dob =$user_dob;
                $user->password = bcrypt(Str::random(6)); //Str::random() à la place de str_random()
                $user->avatar = 'default.png';
                $user->status = 0;
                $user->usertype = 0;
                $user->remember_token = md5(time());
                $user->created_at = Carbon::now();
                $user->updated_at = Carbon::now();
                $user->save();
                return $user;
            }
        }elseif(decrypt($req->get("_form_type_")) == 'VOYAGE'){
            if(User::check_travel_user($phone,$user_dob) || User::check_mail($email))
            {
                $u = (User::check_travel_user($phone,$user_dob)) ? User::check_travel_user($phone,$user_dob) : User::check_mail($email);
                return $u;
            }else{

                $firstname =  $req->firstname;
                $lastname =  $req->lastname;

                $user =  new User();
                $user->firstname=$firstname;
                $user->lastname =$lastname;
                $user->contact=$phone;
                $user->email =$email;
                $user->gender =$req->gender;

                if (empty($job_id)) {
                    // Si $job_id est vide on, ne fait rien
                } else{
                    // Si $job_id est non vide, on continu
                    $user->job_id =$job_id;
                }
                
                $user->date_pc = $user_date_pc;
                $user->dob =$user_dob;
                $user->password = bcrypt(Str::random(6));  // Utilisation de Str::random()
                $user->avatar = 'default.png';
                $user->status = 0;
                $user->usertype = 0;
                $user->remember_token = md5(time());
                $user->created_at = Carbon::now();
                $user->updated_at = Carbon::now();
                $user->save();
                return $user;
            }
        }

    }

    private function saveSpacePersoAccountInfo($souscr_name, $souscr_phone)
    {
        if (!$this->checkIfPersoSpaceExist($souscr_phone)) {
            // Utilisez Str::random pour générer une chaîne aléatoire
            $password = Str::random(6);
            Session::put('_password_sousc', $password);

            return DB::table("espace_perso_account")->insertGetId([
                'name' => $souscr_name,
                // Autres champs ici
            ]);
        }
    }

    private function checkIfPersoSpaceExist($phone)
    {
        $p = str_replace(" ", "", $phone);
       $nb = DB::table("espace_perso_account")->where("phone_number",$p)->count();
       if($nb>0){
        return true;
       }else{
        return false;
       }
    }

    public function sendEmailForAccountPassword($email,$objet,$mail_content)
    {
        $beautymail = app()->make(Beautymail::class);

        $beautymail->send('emails.client_notif_perso_account', ["mail_content"=>$mail_content], function($message) use($email,$objet,$mail_content)
        {
            $message
                ->from('no-reply@monassurance.ci')
                ->to(strtolower($email))
                ->subject($objet);
        });
    }

    private function sendSMSForAccountPassword($mon_sms,$phone)
    {

        $sender_id = rawurlencode("220 170 00"); //Nombre de caractères inférieure à 11 (y compris les espaces)
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("-", "", $phone);
        $url = "http://gateway2.arolitec.com/interface/senderv2.php?user=addams&password=wN44vu5Q&sender=".$sender_id."&receiver=225".$phone."&content=".urlencode($mon_sms);

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
    }

    private function saveInfoAutoInsurance($guarantee, $releasedate, $periode, $sub_type)
    {
        $assuranceAutoInfos =  new assuranceAutoInfos();
        $assuranceAutoInfos->guarante =  $guarantee;
        $assuranceAutoInfos->releasedate = $releasedate;
        $assuranceAutoInfos->periode = $periode;
        $assuranceAutoInfos->subscription_type = $sub_type;
        $assuranceAutoInfos->reduction_commerciale =0;
        $assuranceAutoInfos->save();
        return $assuranceAutoInfos;
    }

    private function saveInfoVoyageInsurance($request)
    {
        $assuranceVoyageInfos =  new assuranceVoyageInfos();
        $assuranceVoyageInfos->destination_country = $request->destination;
        $assuranceVoyageInfos->current_addr = $request->current_addr;
        $assuranceVoyageInfos->destination_addr = $request->dest_addr;
        $assuranceVoyageInfos->departure_date = Carbon::createFromFormat("d/m/Y", $request->date_departure)->toDateString();
        $assuranceVoyageInfos->arrival_date = Carbon::createFromFormat("d/m/Y", $request->date_arrival)->toDateString();
        $assuranceVoyageInfos->nationality_id = $request->nationality;
        $assuranceVoyageInfos->passport_num = $request->num_passport;
        $assuranceVoyageInfos->date_expire_passport = Carbon::createFromFormat("d/m/Y", $request->expire_passport)->toDateString();
        if($assuranceVoyageInfos->save()) return $assuranceVoyageInfos; else return null;
    }

    public function saveProductQuotation($product_id,$assurance_infos_id,$user_id,$product_type,$comp_id,$service)
    {
        $quotation = new Quotation();
        $quotation->product_id= $product_id;
        $quotation->assurance_infos_id = $assurance_infos_id;
        $quotation->user_id = $user_id;
        $quotation->status =0;
        $quotation->product_type=$product_type;
        $quotation->number_n = Quotation::get_unique_number();
        $quotation->company_id = $comp_id;
        $quotation->service_opt = $service;
        $quotation->save();

        return $quotation;
    }

    private function saveOrderStatusActor($quotation)
    {
        DB::table('order_status_actor')->insert([
            'order_id'=>$quotation->id,
            'order_status'=>$quotation->status,
            'actor_id'=>$quotation->user_id,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }

    private function saveOrderStatusAdvisor($quotation)
    {
        DB::table('order_status_actor')->insert([
            'order_id'=>$quotation->id,
            'order_status'=>$quotation->status,
            'actor_id'=>Auth::user()->id,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }

    public function newSinistre(Request $req)
    {
        $sinistre_unique_number = $this->get_sinistre_unique_number();

        DB::table('sinistre')->insert([
            'sin_number'=> $sinistre_unique_number,
            'sin_manager'=> null,
            'client_name'=> $req->sin_name,
            'client_phone'=> $req->sin_phone,
            'client_policy_number'=> $req->sin_police,
            'client_declaration'=> $req->sin_decla,
            'date_sinistre'=> Carbon::createFromFormat("d/m/Y", $req->sin_date)->toDateString(),
            'sin_status'=>0,
            'decision_sin'=>0,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);

        $this->sendSinistreSMS($req->sin_phone,$sinistre_unique_number);
        Session::flash("success","VOUS POUVEZ SUIVRE VOTRE SINISTRE AVEC LE N°$sinistre_unique_number.\nLES DOCUMENTS A FOURNIR SONT LE CONSTAT AMIABLE ET VOTRE DECLARATION.");
        return redirect()->back();
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
      //curl_close($curl);
      if ($err)
      {
      echo false;
      }
      else
      {
      echo true;
      }
    }

    public function get_sinistre_unique_number()
    {
        //$number = str_random(8);
        $today_quote_nb = DB::table('sinistre')
                            ->whereDate('created_at', now()->toDateString())
                            ->count() + 1;

        $chiffre = str_pad($today_quote_nb, 4, '0', STR_PAD_LEFT);
        $_SUFFIX = "SIN";
        $today = date("dmY");
        $number = $_SUFFIX . "/" . $today . "/" . $chiffre;
        $nb = DB::table('sinistre')->where('sin_number', $number)->count();

        if ($nb > 0) {
            return $this->get_sinistre_unique_number();
        }

        return $number;
    }

   /* private function assignOrderToFreeAdvisor($quotation)
    {
        $all_admin = User::where(['usertype'=>99,'status'=>1])->get();
        if(sizeof($all_admin)>0){
            foreach ($all_admin as $key => $user) {
                if($user->hasRole('advisor')){
                    $poids_quote = DB::table('quotation')
                            ->join('order_status_actor','quotation.id','order_status_actor.order_id')
                            ->where([
                                'quotation.status'=>1,
                                'actor_id'=>$user->id
                            ])->count();
                    if($poids_quote==0){
                       DB::table('order_status_actor')->insert([
                           'order_id'=>$quotation->id,
                           'order_status'=>1,
                           'actor_id'=>$user->id,
                           'created_at'=>Carbon::now(),
                           'updated_at'=>Carbon::now()
                       ]);
                       break;
                    }
                    else{
                        $poids_quote = DB::select('select *, MIN(x.countpoids) FROM (select *, count(*) as countpoids from quotation,order_status_actor where quotation.status = 1 and  quotation.id=order_status_actor.order_id group by order_status_actor.id)');
                        dd($poids_quote);
                    }
                }
            }
        }
    }*/

}



