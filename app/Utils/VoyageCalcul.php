<?php
namespace App\Utils;
use App\Models\Reduction;
use Illuminate\Support\Facades\DB;
use App\Utils\AutoParser\ParserCondition;
use App\Utils\AutoParser\ParserRule;
use App\Utils\AutoParser\Parser;
use Carbon\Carbon;
class VoyageCalcul
{


    public static function Traitement($company,$args)
    {
        $comp_quotation = DB::table("auto_companyquotation")->where("companyid",$company->id)->whereAnd("type_assurance",3)->first();

        $parser = new Parser($args);
        if($comp_quotation){
                $comp_quotation_formules = json_decode($comp_quotation->formules, true)["voyage"];

            if(sizeof($comp_quotation_formules)==1) {
                if(sizeof($comp_quotation_formules[0]["zone"]) == 4 ){

                    if(in_array($args["CODE_PAYS"], $comp_quotation_formules[0]["zone"]["except"]["pays"])){

                        if(sizeof($comp_quotation_formules[0]["zone"][$args["ZONE"]]["formule"])==1){
                            return $parser->parse($comp_quotation_formules[0]["zone"]["except"]["duree"]);
                        }else{
                            foreach ($comp_quotation_formules[0]["zone"]["except"]["duree"] as $formule) {
                                if($parser->parse($formule) != -1){
                                 return $parser->parse($formule);
                                }
                            }
                        }

                    }else{
                      if(sizeof($comp_quotation_formules[0]["zone"][$args["ZONE"]]["formule"])==1){
                          return $parser->parse($comp_quotation_formules[0]["zone"][$args["ZONE"]]["formule"]);
                      }else{
                          foreach ($comp_quotation_formules[0]["zone"][$args["ZONE"]]["formule"] as $formule) {
                              if($parser->parse($formule) != -1){
                               return $parser->parse($formule);
                              }
                          }
                      }
                    }
                }else{
                    if(sizeof($comp_quotation_formules[0]["zone"][$args["ZONE"]]["formule"])==1){
                        return $parser->parse($comp_quotation_formules[0]["zone"][$args["ZONE"]]["formule"]);
                    }else{
                        foreach ($comp_quotation_formules[0]["zone"][$args["ZONE"]]["formule"] as $formule) {
                            if($parser->parse($formule) != -1){
                             return $parser->parse($formule);
                            }
                        }
                    }
                }


            }else{

                foreach ($comp_quotation_formules as $formule) {
                 if($args["AGE"]>=$formule["agemin"] && $args["AGE"]<=$formule["agemax"]){
                        if(sizeof($formule["zone"]) == 4 ){
                            if(in_array($args["CODE_PAYS"], $formule["zone"]["except"]["pays"])){
                                return $parser->parse($formule["zone"]["except"]["duree"]);
                            }else{
                              //return $parser->parse();
                              foreach ($formule["zone"][$args["ZONE"]]["formule"] as $f) {
                                  if($parser->parse($f) != -1){
                                   return $parser->parse($f);
                                  }
                              }
                            }
                        }else{
                          if(sizeof($formule["zone"][$args["ZONE"]]["formules"])==1){
                              return $parser->parse($formule["zone"][$args["ZONE"]]["formule"]);
                          }else{
                              foreach ($formule["zone"][$args["ZONE"]]["formule"] as $f) {
                                  if($parser->parse($f) != -1){
                                   return $parser->parse($f);
                                  }
                              }
                          }
                        }

                    }
                }


            }
        }
    }



}
