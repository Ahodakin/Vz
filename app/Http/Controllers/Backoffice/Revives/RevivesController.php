<?php

namespace App\Http\Controllers\Backoffice\Revives;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class RevivesController extends Controller
{

	public function showReviveConfigPage()
    {
    	return view('Backoffice.backend.config.revive-config')->with('isActive','config');
    }

    public function saveReviveForOrder(Request $request)
    {
    	$revive_by_mail = ($request->get('email_notice'))?1:0;
    	$revive_by_sms = ($request->get('sms_notice'))?1:0;
    	if($request->get('qid')){
    		DB::table('revive_client_quotation')->insert([
    			'quotation_id' => $request->get('qid'),
    			'revive_by_mail' => $revive_by_mail,
    			'revive_by_sms' => $revive_by_sms,
                'revive_by_dashboard_alert' => 1,
    			'admin_id' => Auth::user()->id,
    			'advisor_note' => "[<b>".Auth::user()->firstname." ".Auth::user()->lastname."</b>]<br/>".$request->get('obs_revive'),
    			'revive_date' =>  Carbon::createFromFormat("d/m/Y", $request->get('revivedate'))->toDateString(),
    			'created_at' => Carbon::now(),
    			'updated_at' => Carbon::now()
    		]);
    	}
    	return redirect()->back();
    }
}
