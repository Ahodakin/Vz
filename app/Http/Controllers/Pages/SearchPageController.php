<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SearchPageController extends Controller
{
    public function showSearchPage()
    {
    	return view('app.frontend.page-search-quotation-automobile')->with(['active'=>'']);
    }

    public function submitSearch(Request $request)
    {
    	$num_devis = $request->get('num_devis');

        if(strlen($num_devis)<12){
            Session::flash('error','Saisissez un numéro de dévis supérieur à 12 caractères');
            return view('app.frontend.page-search-quotation-automobile')->with(['active'=>'']);
        }

    	$q = DB::table('quotation')->where('number_n','like',"%$num_devis%")->whereOr('policy_number','like',"%$num_devis%")->first();

        if($q->product_type==1)
        $companies = DB::table("auto_company")->where('enabled',1)->get();
        else
        $companies = DB::table("auto_company")->where('has_travel',1)->get();

        if($q){
            if($q->company_id==0){
                Session::flash('info','Pour quelle compagnie souhaitez-vous afficher le dévis N° <<'.$num_devis.'>>');

                return view('app.frontend.page-search-quotation-automobile')->with(['active'=>'','quote'=>$q,'companies'=>$companies]);
            }

            if($q->product_type==1)
            return app('App\Http\Controllers\Pages\ProductPageController')->showQuoteDetails($q->id, $q->company_id);
            else
    		return app('App\Http\Controllers\Pages\ProductPageController')->showTravelQuoteDetails($q->id, $q->company_id);
    	}
    	else{
    		Session::flash('error','Aucun contrat n\'as été trouvé pour le N° <<'.$num_devis.'>>');
    		return view('app.frontend.page-search-quotation-automobile')->with(['active'=>'']);
    	}
    }

    public function submitSearchSinistre(Request $request)
    {
        $num_sinistre = $request->get('num_sinistre');

        if(strlen($num_sinistre)<12){
            Session::flash('error','Saisissez un numéro de sinistre supérieur à 12 caractères');
            return view('app.frontend.page-search-sinistre')->with(['active'=>'','hasSinistre'=>false]);
        }
        $q = DB::table('sinistre')->where('sin_number','like',"%$num_sinistre%")->first();



        if($q){
            Session::flash('success','Un dossier sinistre à été trouvé ');
            return view('app.frontend.page-search-sinistre')->with(['active'=>'','hasSinistre'=>true,'sinistre'=>$q]);
        }
        else{
            Session::flash('error','Aucun dossier sinistre ne correspond au N° <<'.$num_sinistre.'>>');
            return view('app.frontend.page-search-sinistre')->with(['active'=>'','hasSinistre'=>false]);
        }
    }
}
