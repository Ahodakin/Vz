<?php

namespace App\Http\Controllers\Quotation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\assuranceVoyageInfos;
use App\Utils\VoyageCalcul;
use Carbon\Carbon;
use App\Models\OptionnalService;
use App\Models\ReglementaryCoast;
use Illuminate\Support\Facades\DB;
class VoyageQuotationController extends Controller
{
    public function caculVoyageQuotationFromDb($prospect)
    {

        $userInfos = User::where('id',$prospect->user_id)->first();
        $assuranceInfos = assuranceVoyageInfos::where('id',$prospect->assur_voy_id)->first();

        $this->checkQuotationInfos($userInfos, $assuranceInfos);
        $quote = DB::table('quotation')
                    ->where(['assurance_infos_id'=>$prospect->assur_voy_id,'user_id'=>$prospect->user_id])
                    ->first();

        $firstname =$userInfos->firstname;
        $lastname = $userInfos->lastname;
        $email = $userInfos->email;
        $phone = $userInfos->phone;
        $dob = $userInfos->dob;


        $destination_country_id=$assuranceInfos->destination_country;
        $current_addr=$assuranceInfos->current_addr;
        $destination_addr=$assuranceInfos->destination_addr;
        $departure_date=$assuranceInfos->departure_date;
        $arrival_date=$assuranceInfos->arrival_date;

        if(isset($_GET['idcomp']))
        $pref_comp = $_GET['idcomp'];
        else
        $pref_comp = $quote->company_id;

        $serv_opt= $this->format_to_array($quote->service_opt);

        $service= $this->format_service($serv_opt);

        $services  = array();
        if(isset($serv_opt)){
            foreach ($serv_opt as $s) {
                if($s!=""){
                    $serv = DB::table('optional_service')->where('id',$s)->first();
                    $services[$s]["id"] = $serv->id;
                    $services[$s]["service"] = $serv->service;
                    $services[$s]["amount"] = $serv->amount;
                }
            }
        }
        $all_quotation = array();
        $date_of_birth = explode('-', $dob);
        $Tab_arrival_date = explode('-', $arrival_date);
        $age_user = Carbon::createFromDate(intval($date_of_birth[0]), intval($date_of_birth[1]), intval($date_of_birth[2]))->diff(Carbon::now())->format('%y');

        $duree = Carbon::createFromDate($Tab_arrival_date[0], $Tab_arrival_date[1], $Tab_arrival_date[2])->diff(Carbon::parse($departure_date))->days + 1;

        $args = ["NAN"=>-1,"AGE"=>$age_user, "DUREE"=>$duree, "ZONE"=>$prospect->pays_zone,"CODE_PAYS"=>$prospect->pays_code];
        foreach($this->getCompagniesList($pref_comp, $quote->company_id) as $company){
            $all_quotation = $this->setCompanyInfo($company,$all_quotation,$quote);

            $all_quotation[$company->id]["PRIME"] = VoyageCalcul::traitement($company,$args);
            $all_quotation[$company->id]["ASSURANCE"] = $args;
            $all_quotation[$company->id]["SERVICES"] = $services;
            $all_quotation[$company->id]["AMOUNT_SERVICES"] = OptionnalService::SelectedServiceAmount($services);
            $all_quotation[$company->id]["FG"] = ReglementaryCoast::getFraisGestionAroli();
            $all_quotation[$company->id]["PROSPECT"] = $prospect;

        }
        $collection = collect($all_quotation);
        return json_encode(array_values($all_quotation));
    }

    private function checkQuotationInfos($userInfos, $assuranceInfos)
    {
       if($assuranceInfos==null || $userInfos==null){
            return null;
        }
    }

     private function format_to_array($element)
    {

     $result = substr($element, 1, -1);
     $element_array = explode(',', $result);
     return $element_array;
    }

    private function format_service($services)
    {
        $nbre = count($services);
        $service = "[";
        $delimiter = ",";
            for($i=0;$i<$nbre;$i++)
            {
                if($i==$nbre-1){
                    $delimiter = "";
                }
                $service =$service.$services[$i].$delimiter;
            }
        $service =$service."]";
        return $service;
    }

     private function getCompagniesList($pref_comp, $id_comp=0)
    {
        if($pref_comp==0)
            $companies = DB::select("SELECT * from auto_company where has_travel=1 order by id desc");
        else
            $companies = DB::select("SELECT * from auto_company where has_travel=1 order by id='$pref_comp' desc, id asc");

        return $companies;
    }

    private function setCompanyInfo($company,$all_quotation,$quote)
    {
        $all_quotation[$company->id]["id_quote"] = $quote->id;
        $all_quotation[$company->id]["idcomp"] = $company->id;
        $all_quotation[$company->id]["companyname"] = $company->compname;
        $all_quotation[$company->id]["logo"] = $company->complogo;
        $all_quotation[$company->id]["complocation"] = $company->complocation;
        $all_quotation[$company->id]["compphone"] = $company->compphone;
        return $all_quotation;
    }
}
