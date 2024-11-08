<?php
namespace App\Utils;
use App\Models\Reduction;
use App\Models\ReglementaryCoast;
use App\Models\auto_company;
use App\Utils\AutoParser\ParserCondition;
use App\Utils\AutoParser\ParserRule;
use App\Utils\AutoParser\Parser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AutoGuaranteeCalcul
{
    //Calcule de Garantie Responsabilité Civile Fractionnée (Selon la période)
    public static function rc_frac($rc,$comp_frac,$nb_mois)
    {
        $fraction = json_decode($comp_frac,true)["periode"]["RC"][$nb_mois];
        $rc_f =  $rc*$fraction;

        return $rc_f;
    }

    public static function leBaraAutomobile($current_gar,$company_id, $cat_id, $args)
    {
        $comp_quotation = DB::table('auto_companyquotation')->where(['companyid'=>$company_id,'type_assurance'=>1])->orderBy('id','desc')->first();

        $parser = new Parser($args);
        if($comp_quotation){
            if(array_key_exists($current_gar, json_decode($comp_quotation->formules, true)))
                $comp_quotation_formules = json_decode($comp_quotation->formules, true)[$current_gar]["cat".$cat_id]["formule"];
            else
                return 0;
            if(sizeof($comp_quotation_formules)==1) {
                return $parser->parse($comp_quotation_formules[0]);
            }else{

                foreach ($comp_quotation_formules as $formule) {
                    if($parser->parse($formule) != -1){
                     return $parser->parse($formule);
                    }
                }
            }
        }
    }
    //Calcule de Defense et Recours
    public static function def_rec($company_id, $cat_id, $args)
    {
        if($args["FORMULE"]=="toutrisque") return 4240;
        return self::leBaraAutomobile("DR",$company_id, $cat_id, $args);
    }

    //Calcule de Defense et Recours
    public static function rec_ant($company_id, $cat_id, $args)
    {

        return self::leBaraAutomobile("RA",$company_id, $cat_id, $args);
    }

    //Calcule de la taxe fga
    public static function fga($rc, $comp_frac, $nbmois, $tauxfga)
    {
        return self::rc_frac($rc,$comp_frac,$nbmois) * $tauxfga;
    }

    //Calcule de la taxe automobile
    public static function taxe_auto($primenet, $acc, $tauxauto)
    {
        return ($primenet+$acc) * $tauxauto;
    }

    //Calcule de Garantie Individuel Conducteur
    public static function ind_cond($company_id, $cat_id, $args)
    {
        return self::leBaraAutomobile("IC",$company_id, $cat_id, $args);
    }

    //Calcule de Garantie Bris de Glace
    public static function bris_glace($company_id, $cat_id, $args)
    {
        if($args["FORMULE"]=="toutrisque") return 0;
        return self::leBaraAutomobile("BG",$company_id, $cat_id, $args);
    }

    //Calcule de Garantie Incendie
    public static function incendie($company_id, $cat_id, $args)
    {
        return self::leBaraAutomobile("INC",$company_id, $cat_id, $args);
    }

    //Calcule de Garantie Vol avec Agression

    public static function vol($company_id, $cat_id, $args)
    {
        return self::leBaraAutomobile("VOL",$company_id, $cat_id, $args);
    }

    public static function vag($company_id, $cat_id, $args)
    {
        return self::leBaraAutomobile("VAG",$company_id, $cat_id, $args);
    }

    //Calcule de Garantie Vol d'accessoire
    public static function vol_acc($company_id, $cat_id, $args)
    {
        return self::leBaraAutomobile("VOLACC",$company_id, $cat_id, $args);
    }

    //Calcule de Garantie Domage aux véhicule
    public static function dom_veh($company_id, $cat_id, $args)
    {
        return self::leBaraAutomobile("DOMVEH",$company_id, $cat_id, $args);
    }

    //Calcule de Garantie Domage collision
    public static function dom_col($company_id, $cat_id, $args)
    {
        return self::leBaraAutomobile("DOMCOL",$company_id, $cat_id, $args);
    }

    //Calcule de Garantie Vandalisme
    public static function vand($company_id, $cat_id, $args)
    {
        return self::leBaraAutomobile("VAND",$company_id, $cat_id, $args);
    }

    //Calcule de Garantie Vandalisme
    public static function secu_routiere($company_id, $nbplace, $cat_id)
    {
        $company = DB::table('auto_company')->where('id',$company_id)->first();
        if($company){
            $road_safety_guarantee = json_decode($company->road_safety_guarantee, true)["cat$cat_id"];
            if(sizeof($road_safety_guarantee)==3){
                $nbplace = ($nbplace<$road_safety_guarantee[0])? $road_safety_guarantee[0] : $nbplace;
                $place_supp = $nbplace-$road_safety_guarantee[0];
                return ($road_safety_guarantee[1]+$road_safety_guarantee[2]*$place_supp);
            }else{
                if(sizeof($road_safety_guarantee)>=$nbplace)
                    return $road_safety_guarantee[$nbplace-1];
                else
                    return $road_safety_guarantee[sizeof($road_safety_guarantee)-1];
            }
            return 0;

        }
        return 0;
    }

    //getter de Frais accesoire
    public static function accessoire($id_company, $facteur, $selectedformule)
    {
        $company = DB::table('auto_company')->where('id',$id_company)->first();
        if($company){
            $accessory_free = json_decode($company->accessory_free, true)["auto"][$selectedformule];

            if($accessory_free["facteur"]=="temp"){
                return $accessory_free["periode"][$facteur];
            }else{
                $all_pallier = $accessory_free["montant"]["pallier"];

                foreach ($all_pallier as $key => $pallier) {
                    if($facteur > $pallier["min"] and $facteur < $pallier["max"])
                        return $pallier["amount"];

                    $last_amount = $pallier["amount"];
                }
                return $last_amount;
            }
        }
    }

    //getter de Frais accesoire
    public static function accessoire_moto($id_company, $facteur, $selectedformule)
    {
        $company = DB::table('auto_company')->where('id',$id_company)->first();
        if($company){
            $accessory_free = json_decode($company->accessory_free, true)["moto"][$selectedformule];

            if($accessory_free["facteur"]=="temp"){
                return $accessory_free["periode"][$facteur];
            }else{
                $all_pallier = $accessory_free["montant"]["pallier"];

                foreach ($all_pallier as $key => $pallier) {
                    if($facteur > $pallier["min"] and $facteur < $pallier["max"])
                        return $pallier["amount"];

                    $last_amount = $pallier["amount"];
                }
                return $last_amount;
            }
        }
    }

    public static function pourcentageRed_PC($date_perm)
    {
        if(ReglementaryCoast::first()->enable_circulaire==1) return 0;

        $date_perm = explode('-', $date_perm);
        if(sizeof($date_perm)<3) return 0;
         $ageVehicule = Carbon::createFromDate($date_perm[0], $date_perm[1], $date_perm[2])->diff(Carbon::now())->format('%y');

        if(intval($ageVehicule)>=2){
          return 0.05;
        }else{
           return 0;
        }
    }

    //getter de reduction permis
    public static function red_pc($date_perm, $guarantee)
    {
        return self::pourcentageRed_PC($date_perm) *$guarantee;
    }

    public static function pourcentageRed_SP($profession_id)
    {
        $job = DB::table('job')->where('id', $profession_id)->first();

        // Vérifiez si un enregistrement a été trouvé
        if ($job !== null) {
            return $job->discount;
        }

        return 0;
    }

    //Calcule de reduction de la categorie sociaux pro
    public static function red_catso($profession_id, $rc)
    {
        return self::pourcentageRed_SP($profession_id)*$rc;
    }

    public static function pourcentageRed_BNS($nbmois,$company_id)
    {
        $comp = DB::table('auto_company')->where('id',$company_id)->first();
        if($comp->bns_custom==null)
            $bns_array = json_decode(ReglementaryCoast::first()->bns_rate, true)["bns"];
        else
            $bns_array = json_decode($comp->bns_custom, true)["bns"];

       $bns = $bns_array["periode"][$nbmois];
        return $bns;
    }

    public static function red_bns($rc,$nbmois,$company_id)
    {
        return $rc*self::pourcentageRed_BNS($nbmois,$company_id);
    }



    public static function red_com($prime,$company_id,$nb_mois,$formule)
    {
        if($formule=="tsimple") return 0;

        $comp = DB::table('auto_company')->where('id',$company_id)->first();

        if($comp->com_custom==null){
            return $prime*self::max_red_com();
        }
        else{
            $com_rate = json_decode($comp->com_custom, true)["formule"][$formule]["periode"][$nb_mois];

            return $prime*$com_rate;

        }
    }


    public static function max_red_com(){
        $red = Reduction::where('id',1)->first();
        return $red->rate;
    }

    public static function max_red_pc($rc){
        $red = Reduction::where('id',2)->first();
        return $rc*$red->rate;
    }

    public static function max_red_catso($rc){
        $red = Reduction::where('id',3)->first();
        return $rc*$red->rate;
    }

    public static function max_red_bns($rc)
    {

        $bns = Reduction::where('id',4)->first()->rate;
        return $rc*$bns;
    }

    public static function getPNF($PNA, $periode)
    {
       return $PNA*$periode;
    }

    private static function string_to_array($string)
    {
        $result = substr($string, 1, -1);
        $guarantees_array = explode(',', $result);
        return $guarantees_array;
    }
}
