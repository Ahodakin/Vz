<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestAPI extends Controller
{
    public function searchImmat($immat)
    {

    	$quote = DB::table('auto_infos')
                ->join('quotation','quotation.product_id','auto_infos.id')
                ->join('users','quotation.user_id','users.id')
                ->select('auto_infos.*','users.id as uid','users.*')
                ->where([['matriculation',strtoupper(str_replace(" ", "",$immat))],['category','<>',5]])->orderBy('auto_infos.id','desc')->first();
    	if($quote) return json_encode($quote); else echo "0";

    }

    public function searchImmatMoto($immat)
    {

        $quote = DB::table('auto_infos')
                ->join('quotation','quotation.product_id','auto_infos.id')
                ->join('users','quotation.user_id','users.id')
                ->join('make','auto_infos.make_id','make.id')
                ->select('auto_infos.*','users.id as uid','users.*','make.code')
                ->where([['matriculation',strtoupper(str_replace(" ", "",$immat))],['category','=',5]])->orderBy('auto_infos.id','desc')->first();
        if($quote) return json_encode($quote); else echo "0";

    }

    public function searchTravelProfil($id)
    {

        $travel_profiles = DB::table('users')
                     ->join('quotation', 'users.id','quotation.user_id')
                     ->join('assurance_voyage_infos','assurance_voyage_infos.id','quotation.assurance_infos_id')
                     ->join('made_quote','made_quote.quote_id','quotation.id')
                     ->select('users.*','assurance_voyage_infos.nationality_id','assurance_voyage_infos.passport_num','assurance_voyage_infos.date_expire_passport')
                     ->where('made_quote.account_id','=',Auth::guard('space_perso')->user()->id)
                     ->where('quotation.product_type',3)
                     ->where('users.id',$id)->first();
        if($travel_profiles) return json_encode($travel_profiles); else echo "0";

    }

     public function getGuarantiesFormule($idcomp, $formule)
    {
        $comp = DB::table('auto_company')->where('id',$idcomp)->first();

        if($comp){
            $formule = json_decode($comp->$formule, true)["cat1"]["garanties"];
            return json_encode($formule);
        } else {
             echo "0";
        }

    }




}
