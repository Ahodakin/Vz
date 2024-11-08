<?php

namespace App\Http\Controllers\MySpace;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\EspacePersoAccount;
use App\Models\Quotation;
use App\Models\assuranceAutoInfos;
use Illuminate\Support\Facades\Session;
use Hash;
use Carbon\Carbon;


class MySpaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.persoaccount');
    }

    public function showSpacePage()
    {
    	 $contrats_auto = DB::table('quotation')
                        ->join('assurance_auto_infos', 'assurance_auto_infos.id','quotation.assurance_infos_id')
                        ->join('auto_company', 'auto_company.id','quotation.company_id')
                        ->join('periode', 'periode.id','assurance_auto_infos.periode')
                        ->join('users', 'users.id','quotation.user_id')
                        ->join('made_quote','made_quote.quote_id','quotation.id')
                        ->select('quotation.id as qid','number_n','auto_company.compname', 'auto_company.id as comp_id', 'guarante', 'inbox_amount', 'quotation.id','nbmois','periode.periode','assurance_auto_infos.releasedate','firstname','lastname','quotation.created_at')
                        ->where(['quotation.status'=>5, 'made_quote.account_id'=>Auth::guard('space_perso')->user()->id])->get();

        $contrats_voyage = DB::table('quotation')
                            ->join("users","users.id","quotation.user_id")
                            ->join('made_quote','made_quote.quote_id','quotation.id')
                            ->join("assurance_voyage_infos","assurance_voyage_infos.id","quotation.assurance_infos_id")
                            ->join("auto_company","auto_company.id","quotation.company_id")
                            ->select("quotation.*","assurance_voyage_infos.*","quotation.id as qid","quotation.product_type","assurance_infos_id","firstname","lastname","contact","email","compname","complogo")
                            ->where([["quotation.status","=",5],["product_type","=",3],['made_quote.account_id',"=",Auth::guard('space_perso')->user()->id]])
                            ->orderBy("quotation.id","desc")->get();

        $devis_voyage = DB::table('quotation')
                            ->join("users","users.id","quotation.user_id")
                            ->join('made_quote','made_quote.quote_id','quotation.id')
                            ->join("assurance_voyage_infos","assurance_voyage_infos.id","quotation.assurance_infos_id")
                            ->select("quotation.*","assurance_voyage_infos.*","quotation.id as qid","quotation.product_type","assurance_infos_id","firstname","lastname","contact","email")
                            ->where("quotation.status","<",5)
                            ->where("product_type","=",3)
                            ->where("made_quote.account_id","=",Auth::guard('space_perso')->user()->id)
                            ->orderBy("quotation.id","desc")->get();

                        $devis_auto = DB::table('quotation')
                        ->join('assurance_auto_infos', 'assurance_auto_infos.id','quotation.assurance_infos_id')
                        ->join('periode', 'periode.id','assurance_auto_infos.periode')
                        ->join('users', 'users.id','quotation.user_id')
                        ->join('made_quote','made_quote.quote_id','quotation.id')
                        ->select('quotation.id as qid','number_n','guarante', 'nbmois','periode.periode','assurance_auto_infos.releasedate','firstname','lastname','quotation.created_at','quotation.company_id')
                        ->where("product_type","=",1)
                        ->where('made_quote.account_id','=',Auth::guard('space_perso')->user()->id)
                        ->where('quotation.status','<',5)->orderBy("quotation.id","desc")->get();



        $directory = base_path()."/../app.monassurance.ci/public/back/assets/js/vendor/file-upload/server/php/uploads/files_client/file/thumbnail/";

        $files = scandir($directory);
        $fitlered_files=[];
        foreach ($contrats_auto as $key => $c) {
            $fitlered_files = array_filter($files, function($file) use ($c){
                return strpos($file, $c->qid."_") === 0;
            });
        }
        $periodes = DB::table('periode')->get();

    	return view('app.frontend.myspace')->with([
    		'contrats_auto'=>$contrats_auto,
            'devis_auto'=>$devis_auto,
            'contrats_voyage'=>$contrats_voyage,
            'devis_voyage'=>$devis_voyage,
            'active'=>'myspace',
            'files' => $fitlered_files,
            'periodes'=>$periodes
    		]);
    }

    public function UpdateProfile(Request $request)
    {
        EspacePersoAccount::where("id", Auth::guard('space_perso')->user()->id)->update([
            "name"=>$request->name
        ]);
        Session::flash("success","Votre profile a correctement été mis à jour!");
        return redirect()->back();
    }

    public function updateAccountPassword(Request $request)
    {
        $current_password = Auth::guard('space_perso')->user()->password;
        if(Hash::check($request->currentpassword, $current_password)){
            if($request->newpassword == $request->newpasswordrepeat){
                $user_id = Auth::guard('space_perso')->user()->id;
                $obj_user = EspacePersoAccount::find($user_id);
                $obj_user->password = Hash::make($request->newpassword);
                $obj_user->save();
                Session::flash("success","Votre mot de passe a correctement été mis à jour!");
            }else{
                Session::flash("error","Les deux mots de passe saisis ne correstpondent pas.");
            }
        }else{
            Session::flash("error","Votre mot de passe est incorrect!");
        }
        return redirect()->back();
    }

    public function renewContract(Request $request)
    {
        $old_q = Quotation::where('id',$request->id_cont)->first();
        $old_assur_info = assuranceAutoInfos::where('id',$old_q->assurance_infos_id)->first();

        $assuranceAutoInfos =  new assuranceAutoInfos();
        $assuranceAutoInfos->guarante =  $old_assur_info->guarante;
        $assuranceAutoInfos->releasedate = Carbon::createFromFormat("d/m/Y", $request->get('newreleasedate'))->toDateString();
        $assuranceAutoInfos->periode = $request->get('periode');
        $assuranceAutoInfos->subscription_type = $old_assur_info->subscription_type;
        $assuranceAutoInfos->reduction_commerciale =0;
        $assuranceAutoInfos->save();



        $quotation = new Quotation();
        $quotation->product_id= $old_q->product_id;
        $quotation->assurance_infos_id = $assuranceAutoInfos->id;
        $quotation->user_id = $old_q->user_id;
        $quotation->status =0;
        $quotation->product_type=$old_q->product_type;
        $quotation->number_n = Quotation::get_unique_number();
        $quotation->company_id = $old_q->company_id;
        $quotation->service_opt = $old_q->service_opt;
        $quotation->delivery_location = $old_q->delivery_location;
        $quotation->phone_client = $old_q->phone_client;
        $quotation->renew_order = 1;
        $quotation->save();

        $this->saveOrderStatusActor($quotation);
        $this->storeWhoMadeQuote($quotation->id, Auth::guard('space_perso')->user()->id);

        return \Redirect::route('details.quote.auto', ['id_quote' => $quotation->id,'id_comp'=>$quotation->company_id]);
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

    private function storeWhoMadeQuote($quote_id,$space_account_id)
  {
       DB::table("made_quote")->insert([
            "quote_id"=>$quote_id,
            "account_id"=>$space_account_id,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ]);
  }

    public function loadContrat($id_contrat)
    {
        $contrats = DB::select('SELECT
        number_n,
        firstname,
        lastname,
        email,
        contact,
        product_type,
        quotation.status,
        quotation.product_id,
        quotation.company_id,
        quotation.created_at,
        delivery_location,
        inbox_amount,
        periode.id as per_id,
        periode.periode as lib_per,
        periode.nbmois,
        periode.fraction,
        quotation.id as qid,
        assurance_auto_infos.id as aid,
        assurance_auto_infos.periode as ass_periode_id,
        assurance_auto_infos.guarante,
        assurance_auto_infos.releasedate,
        auto_company.id as comp_id,
        compname,
        complogo
        from
        quotation,
        assurance_auto_infos,
        auto_infos,
        periode,
        auto_company,
        users
        where quotation.id="'.$id_contrat.'" and users.id=user_id and auto_company.id=quotation.company_id and periode.id=assurance_auto_infos.periode and auto_infos.id=product_id and assurance_auto_infos.id=assurance_infos_id and quotation.status=5');

        if($contrats) return json_encode($contrats[0]); else echo 0;
    }

    public function showAutoQuotationPage()
    {
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

        $cars = DB::table('auto_infos')
                        ->join('quotation', 'auto_infos.id','quotation.product_id')
                        ->join('make', 'auto_infos.make_id','make.id')
                        ->join('auto_categories', 'auto_infos.category','auto_categories.id')
                        ->join('car_type', 'auto_infos.type_id','car_type.id_type')
                        ->join('made_quote','made_quote.quote_id','quotation.id')
                        ->select('quotation.id as qid','auto_infos.*','make.code as marque','car_type_code','categorie','shortdesc')
                        ->where('made_quote.account_id','=',Auth::guard('space_perso')->user()->id)

                        ->where('car_type.id_type','<>',7)->orderBy("qid","desc")->groupBy("auto_infos.matriculation")->get();

        return view('app.frontend.myspace-quotation-auto')->with([
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
            'optional_service'=> $optional_service,
            'cars'=> $cars
        ]);
    }

    public function showMotoQuotationPage()
    {
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

        $cars = DB::table('auto_infos')
                        ->join('quotation', 'auto_infos.id','quotation.product_id')
                        ->join('make', 'auto_infos.make_id','make.id')
                        ->join('auto_categories', 'auto_infos.category','auto_categories.id')
                        ->join('car_type', 'auto_infos.type_id','car_type.id_type')
                        ->join('made_quote','made_quote.quote_id','quotation.id')
                        ->select('quotation.id as qid','auto_infos.*','make.code as marque','car_type_code','categorie','shortdesc')
                        ->where('made_quote.account_id','=',Auth::guard('space_perso')->user()->id)

                        ->where('car_type.id_type','=',7)->orderBy("qid","desc")->groupBy("auto_infos.matriculation")->get();

        return view('app.frontend.myspace-quotation-moto')->with([
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
            'optional_service'=> $optional_service,
            'cars'=> $cars
        ]);
    }

    public function showVoyageQuotationPage()
    {
        $companies = DB::table('auto_company')->where(['has_travel'=>1])->get();
        $pays = DB::table('pays')->get();
        $optional_service = DB::table('optional_service')->where(['product_type'=>3])->get();

       $travel_profiles = DB::table('users')
                    ->join('quotation', 'users.id','quotation.user_id')
                    ->join('assurance_voyage_infos','assurance_voyage_infos.id','quotation.assurance_infos_id')
                    ->join('made_quote','made_quote.quote_id','quotation.id')
                    ->select('users.*','assurance_voyage_infos.nationality_id','assurance_voyage_infos.passport_num','assurance_voyage_infos.date_expire_passport')
                    ->where('made_quote.account_id','=',Auth::guard('space_perso')->user()->id)
                    ->where('quotation.product_type',3)->get();



        return view('app.frontend.myspace-quotation-travel')->with([
            'active'=>'voyage',
            'pays'=> $pays,
            'companies'=>$companies,
            'optional_service'=> $optional_service,
            'travel_profiles'=>$travel_profiles
        ]);
    }


}
