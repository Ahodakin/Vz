<?php

namespace App\Http\Controllers\Quotation;

use App\Models\Quotation;
use App\Models\ReglementaryCoast;
use App\Models\OptionnalService;
use App\Models\autoCompany;
use App\Models\Periode;
use App\Models\User;
use App\Models\autoInfos;
use App\Models\assuranceAutoInfos;
use App\Utils\AutoGuaranteeCalcul as Calcul;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class AutoQuotationController extends Controller
{
    public function caculAutoQuotationFromDb($autoInfo_ID, $user_ID, $assurance_ID)
    {

        $autoInfos = autoInfos::where('id',$autoInfo_ID)->first();
        $userInfos = User::where('id',$user_ID)->first();
        $assuranceInfos = assuranceAutoInfos::where('id',$assurance_ID)->first();

        $this->checkQuotationInfos($autoInfos, $userInfos, $assuranceInfos);

        $quote = DB::table('quotation')
                    ->where(['assurance_infos_id'=>$assurance_ID,'user_id'=>$user_ID,'product_id'=>$autoInfo_ID])
                    ->first();

        $matriculation = $autoInfos->immatriculation;
        $model_id = $autoInfos->model_id;
        $category_id = $autoInfos->category;
        $zone = $autoInfos->parkingzone;
        $energy = $autoInfos->energy;
        $power = $autoInfos->power;
        $cu = $autoInfos->charge_utile;
        $cylindree = $autoInfos->cylindree;
        $type_id = $autoInfos->type_id;
        $firstrelease = $autoInfos->firstrelease;
        $placesnumber = $autoInfos->placesnumber;
        $vneuve = $autoInfos->vneuve;
        $vvenale = $autoInfos->vvenale;

        $firstname =$userInfos->firstname;
        $lastname = $userInfos->lastname;
        $email = $userInfos->email;
        $phone = $userInfos->phone;
        $date_perm = $userInfos->date_pc;

        $periode_id= $assuranceInfos->periode;
        $datepriseeffet = $assuranceInfos->datepriseeffet;
        $type_subscription=$assuranceInfos->subscription_type;
        $selectedformule=$assuranceInfos->guarante;

        $selected_guaranties_array = $this->format_to_array($selectedformule);

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

        $rc = ReglementaryCoast::getAmountRC($category_id, $zone, $energy, $power, $cu, $type_id,$cylindree);
        $fg_aroli = ReglementaryCoast::getFraisGestionAroli();
        $all_quotation = array();
        if($periode_id==1)
        $args = ["NAN"=>-1,"NPLACE"=>$placesnumber, "ANN"=>1, "RC"=>$rc,"VN"=>$vneuve,"VV"=>$vvenale];
        else
        $args = ["NAN"=>-1,"NPLACE"=>$placesnumber, "FRAC"=>1, "RC"=>$rc,"VN"=>$vneuve,"VV"=>$vvenale];
        $args["FORMULE"] = $selectedformule;


        if($selectedformule=="toutrisque")
        $args["FORMULE_INT"] = 4;
        else
        $args["FORMULE_INT"] = 0;



        foreach($this->getCompagniesList($pref_comp, $quote->company_id) as $company){

            $all_quotation = $this->setCompanyInfo($company, $category_id, $all_quotation,$quote);

            $all_quotation = $this->setGuarantiesCoast($rc,$periode_id, $date_perm, $userInfos->job_id, $company, $all_quotation,$type_subscription, $selectedformule,$selected_guaranties_array, $category_id, $args);

            $all_quotation = $this->setReglementaryGuarantiesCoast( $company, $periode_id, $all_quotation,$type_subscription, $category_id, $selectedformule,$selected_guaranties_array);
            $all_quotation = $this->setPeriodeInfos($company, $all_quotation, $periode_id, $datepriseeffet);
            $all_quotation = $this->setTaxeAmount($company, $all_quotation, $periode_id, $services, $fg_aroli, $category_id, $selectedformule);
        }
         $qu_sorted = collect($all_quotation)->sortBy("TTC");

        if($pref_comp==0)
        return json_encode($qu_sorted->values()->all());

        return json_encode(array_values($all_quotation));
    }

   private function isActiveMaxDiscount()
   {
       return ReglementaryCoast::first()->active_max_discount;
   }

    private function checkQuotationInfos($autoInfos, $userInfos, $assuranceInfos)
    {
       if($autoInfos == null || $assuranceInfos==null || $userInfos==null){
            return null;
        }
    }

     private function format_to_array($element)
    {

     $result = substr($element, 1, -1);
     $element_array = explode(',', $result);
     return $element_array;
    }

    ########################################################################################################################################################################################



    private function getCompagniesList($pref_comp, $id_comp=0)
    {
        if($pref_comp==0)
            $companies = DB::select("SELECT * from auto_company where enabled=1 order by id desc");
        else
            $companies = DB::select("SELECT * from auto_company where enabled=1 order by id='$pref_comp' desc, id asc");

        //if($id_comp!=0) $companies = DB::select("SELECT * from auto_company where id='$id_comp'");
        return $companies;
    }

    private function setCompanyInfo($company, $cat_id, $all_quotation,$quote)
    {
        $formule_baseguar = json_decode($company->baseguar, true)["cat$cat_id"]["garanties"];
        $formule_tsimple = json_decode($company->tsimple, true)["cat$cat_id"]["garanties"];
        $formule_tcomplet = json_decode($company->tcomplet, true)["cat$cat_id"]["garanties"];
        $formule_tcol = json_decode($company->tcol, true)["cat$cat_id"]["garanties"];
        $formule_toutrisque = json_decode($company->toutrisque, true)["cat$cat_id"]["garanties"];

        $all_quotation[$company->id]["id_quote"] = $quote->id;
        $all_quotation[$company->id]["idcomp"] = $company->id;
        $all_quotation[$company->id]["companyname"] = $company->compname;
        $all_quotation[$company->id]["logo"] = $company->complogo;
        $all_quotation[$company->id]["complocation"] = $company->complocation;
        $all_quotation[$company->id]["compphone"] = $company->compphone;
        $all_quotation[$company->id]["baseguar"] = $formule_baseguar;
        $all_quotation[$company->id]["tsimple"] = $formule_tsimple;
        $all_quotation[$company->id]["tcomplet"] = $formule_tcomplet;
        $all_quotation[$company->id]["tcol"] = $formule_tcol;
        $all_quotation[$company->id]["toutrisque"] = $formule_toutrisque;
        return $all_quotation;
    }


    private function setGuarantiesCoast($rc,$periode_id, $date_perm, $profession_id, $company, $all_quotation, $type_subscription, $selectedformule,$selected_guaranties_array=[], $cat_id, $args)
    {

        $compformules = ["RC","BG","IC","INC","VAND","DOMVEH","DOMCOL","VOL","VAG","VOLACC","DR","RA", "SECU_ROU"];

         $primenet =0;
         $all_reduction_pc = 0;
         $all_reduction_sp = 0;
         $all_reduction_bns = 0;
         $all_reduction_bns = 0;
         $all_reduction_com = 0;
        foreach($compformules as $cc){
            $rst = $this->callAppropriateGuanranteeFunction($cc,$periode_id,$date_perm, $profession_id,$rc, $company->id, $cat_id, $args);

            $all_quotation[$company->id][$cc] =  $rst[1];
            $all_quotation[$company->id][$cc.'_reduite_pc'] =  $rst[2];
            $all_quotation[$company->id][$cc.'_reduite_sp'] =  $rst[3];
            $all_quotation[$company->id][$cc.'_reduite_bns'] =  $rst[4];
            $all_quotation[$company->id][$cc.'_reduite_com'] =  $rst[5];

            $all_quotation[$company->id][$cc.'_reduite'] =  $rst[6];

            if($type_subscription=='F'){
                $formule = json_decode($company->$selectedformule, true)["cat$cat_id"]["garanties"];
                $primenet += $this->getPrimeNetFormule($formule, $cc, $rst[6]);
                if($this->isGuaranteeInSelectedFormule($formule, $cc)){
                    $all_reduction_pc += $rst[1]-$rst[2];
                    $all_reduction_sp += $rst[1]-$rst[3];
                    $all_reduction_bns += $rst[1]-$rst[4];
                    $all_reduction_com += $rst[1]-$rst[5];
                }
            }
            else{
                $primenet += $this->getPrimeNetGuanranties($selected_guaranties_array, $cc, $rst[6]);
                $selected_guaranties = $this->format_garantie($selected_guaranties_array);
                if($this->isGuaranteeInSelectedFormule($selected_guaranties, $cc)){
                    $all_reduction_pc += $rst[1]-$rst[2];
                    $all_reduction_sp += $rst[1]-$rst[3];
                    $all_reduction_bns += $rst[1]-$rst[4];
                    $all_reduction_com += $rst[1]-$rst[5];
                }
            }
        }
            $periode = Periode::where('id',$periode_id)->first();

            $all_quotation[$company->id]['PNA'] = $primenet;
            $all_quotation[$company->id]['ALL_REDUCTION_PC'] = $all_reduction_pc;
            $all_quotation[$company->id]['ALL_REDUCTION_SP'] = $all_reduction_sp;
            $all_quotation[$company->id]['ALL_REDUCTION_BNS'] = $all_reduction_bns;
            $all_quotation[$company->id]['ALL_REDUCTION_COM'] = $all_reduction_com;
            $all_quotation[$company->id]['RED_PC'] = Calcul::pourcentageRed_PC($date_perm);
            $all_quotation[$company->id]['RED_SP'] = Calcul::pourcentageRed_SP($profession_id);
            $all_quotation[$company->id]['RED_BNS'] = Calcul::pourcentageRed_BNS($periode->nbmois, $company->id);
            if($company->com_custom==null)
                $com_rate = Calcul::max_red_com();
            else
                $com_rate = json_decode($company->com_custom, true)["formule"][$selectedformule]["periode"][$periode->nbmois];

            if($selectedformule=="tsimple") $com_rate = 0;



            $all_quotation[$company->id]['RED_COM'] = $com_rate;

        return $all_quotation;
    }

    private function setReglementaryGuarantiesCoast($company,$periode_id, $all_quotation, $type_subscription, $cat_id, $selectedformule,$selected_guaranties_array=[])
    {
        $periode = Periode::where('id',$periode_id)->first();

        $all_quotation[$company->id]["RC_frac"] = Calcul::rc_frac($all_quotation[$company->id]["RC_reduite"], $company->fractionnement_guar, $periode->nbmois);

        $formule = json_decode($company->$selectedformule, true)["cat$cat_id"]["garanties"];

        if($type_subscription=='F')
        $guaranties_selected = $formule;
        else
        $guaranties_selected = $this->format_garantie($selected_guaranties_array);

        $all_quotation[$company->id]["formule_selected"] = $guaranties_selected;

        return $all_quotation;
    }

    private function callAppropriateGuanranteeFunction($cc,$periode_id,$date_perm, $profession_id,$rc, $company_id, $cat_id, $args)
    {
        $val = 0;
        $val_red = 0;
        $company_discount = json_decode(autoCompany::where("id",$company_id)->first()->company_discount, true)["discount"];

        if($cc=='RC'){
            $val = $rc;
        }
        if($cc=='IC'){
            $val = Calcul::ind_cond($company_id, $cat_id, $args);

        }
        if($cc=='BG'){
            $val = Calcul::bris_glace($company_id, $cat_id, $args);

        }
        if($cc=='INC'){
            $val = Calcul::incendie($company_id, $cat_id, $args);
        }
        if($cc=='VOL'){
            $val = Calcul::vol($company_id, $cat_id, $args);
        }
        if($cc=='VAG'){
            $val = Calcul::vag($company_id, $cat_id, $args);
        }
        if($cc=='VOLACC') {
            $val = Calcul::vol_acc($company_id, $cat_id, $args);
        }
        if($cc=='DOMVEH') {
            $val = Calcul::dom_veh($company_id, $cat_id, $args);
        }
        if($cc=='DOMCOL') {
            $val = Calcul::dom_col($company_id, $cat_id, $args);
        }
        if($cc=='VAND'){
            $val = Calcul::vand($company_id, $cat_id, $args);
        }
        if($cc=='DR'){
            $val = Calcul::def_rec($company_id, $cat_id, $args);

        }
        if($cc=='RA'){
            $val = Calcul::rec_ant($company_id, $cat_id, $args);
        }

        if($cc=='SECU_ROU'){
            $val = Calcul::secu_routiere($company_id,$args["NPLACE"],$cat_id);
        }

        $nb_mois = Periode::where('id',$periode_id)->first()->nbmois;

        if($company_discount["model"]==1){
        $val_red_pc = $this->getGuaranteeDiscount_PC($company_discount,$cc,$val,$date_perm);

        $val_red_sp = $this->getGuaranteeDiscount_SP($company_discount,$cc,$val,$profession_id);

        $val_red_bns = $this->getGuaranteeDiscount_BNS($company_discount,$cc,$val,$periode_id, $company_id);

        $val_red_com = $this->getGuaranteeDiscount_COM($company_discount,$cc,$val,$val, $company_id, $nb_mois ,$args["FORMULE"]);

        $total_reduite1 = 4*$val - ($val_red_pc+$val_red_sp+$val_red_bns+$val_red_com);

        $val_reduite = $val - $total_reduite1;
        }
        elseif($company_discount["model"]==2){
            $val_red_pc = $this->getGuaranteeDiscount_PC($company_discount,$cc,$val,$date_perm);

            $val_red_sp = $this->getGuaranteeDiscount_SP($company_discount,$cc,$val_red_pc,$profession_id);

            $val_red_bns = $this->getGuaranteeDiscount_BNS($company_discount,$cc,$val_red_sp,$periode_id, $company_id);

            $val_red_com = $this->getGuaranteeDiscount_COM($company_discount,$cc,$val,$val_red_bns, $company_id, $nb_mois ,$args["FORMULE"]);

            $val_reduite = $val_red_com;
        }else{
            $val_red_pc = $this->getGuaranteeDiscount_PC($company_discount,$cc,$val,$date_perm);
            $val_red_sp = $this->getGuaranteeDiscount_SP($company_discount,$cc,$val_red_pc,$profession_id);


            $pourc_red_sp = Calcul::pourcentageRed_SP($profession_id);
            $pourc_red_pc = Calcul::pourcentageRed_PC($date_perm);


            $val_red_bns1 = $this->getGuaranteeDiscount_BNS_2($company_discount,$cc,$val,$pourc_red_sp+$pourc_red_pc);
            $val_red_bns = $this->getGuaranteeDiscount_BNS($company_discount,$cc,$val_red_bns1,$periode_id, $company_id);

            $val_red_com = $this->getGuaranteeDiscount_COM($company_discount,$cc,$val,$val_red_bns, $company_id, $nb_mois ,$args["FORMULE"]);

            $val_reduite = $val_red_com;
        }


        return [$cc,$val,$val_red_pc,$val_red_sp,$val_red_bns,$val_red_com,$val_reduite];
    }

    public function getGuaranteeDiscount_PC($company_discount,$cc,$val,$date_perm)
    {

        if(in_array($cc,$company_discount["permis"]))
            $val_red = $val - Calcul::red_pc($date_perm, $val);
        else
            $val_red = $val;

        return $val_red;
    }

    public function getGuaranteeDiscount_SP($company_discount,$cc,$val,$profession_id)
    {
        if(in_array($cc,$company_discount["socpro"]))
            $val_red = $val - Calcul::red_catso($profession_id, $val);
        else
            $val_red = $val;

        return $val_red;
    }

    public function getGuaranteeDiscount_BNS($company_discount,$cc,$val,$periode_id,$company_id)
    {
        $periode = Periode::where('id',$periode_id)->first();

        if(in_array($cc,$company_discount["bns"]))
            $val_red = $val - Calcul::red_bns($val, $periode->nbmois,$company_id);
        else
            $val_red = $val;

        return $val_red;
    }

    public function getGuaranteeDiscount_BNS_2($company_discount,$cc,$val,$red)
    {

        if(in_array($cc,$company_discount["socpro"]))
        $val_red = $val-$val*$red;
        else
        $val_red = $val;

        return $val_red;
    }

    public function getGuaranteeDiscount_COM($company_discount,$cc,$val,$val_red_bns,$company_id,$nb_mois,$formule)
    {

        if(in_array($cc,$company_discount["com"]))
            $val_red = $val_red_bns - Calcul::red_com($val_red_bns,$company_id,$nb_mois,$formule);
        else
            $val_red = $val_red_bns;




         return $val_red;
    }



    private function getPrimeNetFormule($selectedformule, $guarantee, $cout_guar)
    {
        if($this->isGuaranteeInSelectedFormule($selectedformule, $guarantee) && $guarantee!="RC") return $cout_guar;
    }

    private function getPrimeNetGuanranties($selected_guaranties_array, $guarantee, $cout_guar)
    {
        $selected_guaranties = $this->format_garantie($selected_guaranties_array);
        if($this->isGuaranteeInSelectedFormule($selected_guaranties, $guarantee) && $guarantee!="RC") return $cout_guar;
    }

    private function setPeriodeInfos($company, $all_quotation, $periode_id, $datepriseeffet)
    {
        $periode = Periode::where('id',$periode_id)->first();

        $fraction = json_decode($company->fractionnement_guar,true)["periode"]["OTHER"][$periode->nbmois];

        $all_quotation[$company->id]["periode"] = $fraction;
        $all_quotation[$company->id]["desc_periode"] = $periode->periode;
        $all_quotation[$company->id]["nbmois"] = $periode->nbmois;
        $all_quotation[$company->id]["datepriseeffet"] = $datepriseeffet;
        $all_quotation[$company->id]["expiredate"] = date('Y-m-d', strtotime("+$periode->nbmois months", strtotime($datepriseeffet)));
        $all_quotation[$company->id]["PNF"] = Calcul::getPNF($all_quotation[$company->id]["PNA"],$fraction) +$all_quotation[$company->id]["RC_frac"];
        return $all_quotation;
    }

    private function setTaxeAmount($company, $all_quotation, $periode_id, $serv_opt, $fg_aroli, $category_id, $selectedformule)
    {
        $periode = Periode::where('id',$periode_id)->first();
        $all_quotation[$company->id]["servopt"] = $serv_opt;
        if($category_id==5)
        $accessory_free = json_decode($company->accessory_free, true)["moto"][$selectedformule];
        else
        $accessory_free = json_decode($company->accessory_free, true)["auto"][$selectedformule];

        if($accessory_free["facteur"]=="temp"){
            $facteur = $periode->nbmois;
        }else{
            $facteur = $all_quotation[$company->id]["PNF"];
        }
        $all_quotation[$company->id]["som_serv"] = OptionnalService::SelectedServiceAmount($serv_opt)*$periode->nbmois;
        $all_quotation[$company->id]["FGA"] = Calcul::fga($all_quotation[$company->id]["RC_reduite"],$company->fractionnement_guar, $periode->nbmois, ReglementaryCoast::first()->fga);
        $all_quotation[$company->id]["FG"] = $fg_aroli;
        if($category_id==5){
            $all_quotation[$company->id]["ACC"] = Calcul::accessoire_moto($company->id, $facteur, $selectedformule);
            $all_quotation[$company->id]["ACC_reduite"] = Calcul::accessoire_moto($company->id, $facteur, $selectedformule);
        }else{
            $all_quotation[$company->id]["ACC"] = Calcul::accessoire($company->id, $facteur,$selectedformule);
            $all_quotation[$company->id]["ACC_reduite"] = Calcul::accessoire($company->id, $facteur,$selectedformule);
        }

        $all_quotation[$company->id]["TAXE"] = Calcul::taxe_auto($all_quotation[$company->id]["PNF"],$all_quotation[$company->id]["ACC"], ReglementaryCoast::first()->autotaux);
        $all_quotation[$company->id]["CEDEAO"] =  ReglementaryCoast::first()->cedeao;
        $all_quotation[$company->id]["TTC"] = $all_quotation[$company->id]["PNF"]+$all_quotation[$company->id]["ACC"]+$all_quotation[$company->id]["FGA"]+$all_quotation[$company->id]["CEDEAO"]+$all_quotation[$company->id]["TAXE"]+$all_quotation[$company->id]["FG"];
        return $all_quotation;
    }

    private function isGuaranteeInSelectedFormule($selectedformule, $guarantee)
    {
        return (in_array($guarantee,$this->garantie_to_array($selectedformule)));
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

    private function garantie_to_array($guarantee)
    {
        $result = substr($guarantee, 1, -1);
        $guarantees_array = explode(',', $result);
        return $guarantees_array;
    }

    // formatage des garanties
    private function format_garantie($my_guaranties)
    {
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
        return $garantie;
    }


    private function arrondir($valeur, $arrondi)
    {
        return round($valeur/$arrondi)*$arrondi;
    }

    public function createNewCarMake(Request $request)
    {
        $make = $request->new_make;

        if($make=="") return 0;

            $id = DB::table("make")->insertGetId([
                "code" => strtoupper($make),
                "title" => $make,
                "isMoto" => 0
            ]);

            return json_encode(DB::table('make')->where("id",$id)->first());
    }
}
