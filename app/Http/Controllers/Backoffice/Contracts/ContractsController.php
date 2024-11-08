<?php

namespace App\Http\Controllers\Backoffice\Contracts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Reduction;
use App\Models\Backoffice\Quotation;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Session;
use App\Models\Backoffice\assuranceAutoInfos;
use Illuminate\Support\Carbon;
class ContractsController extends Controller
{

    public function showRates()
    {
        // Récupérer la première réduction pour le produit avec l'ID 1
        $auto_reduction = Reduction::where('id_produit', 1)->get();
    
        if (!$auto_reduction) {
            Session::flash('error', 'Aucune réduction trouvée pour ce produit.');
        }
    
        return view('Backoffice.backend.config.rates', compact('auto_reduction'))->with(['isActive' => 'config']);
    }
    
    


    public function editRate(Request $req)
    {
        // Vérifiez si l'ID de réduction est valide
        $reduction = Reduction::find($req['idred']);
    
        if (!$reduction) {
            Session::flash('error', 'Aucune mise à jour effectuée. Vérifiez l\'ID de réduction.');
            return redirect()->route('configRate');
        }
    
        // Mettez à jour la réduction
        $reduction->update([
            'rate' => $req['rate'],
        ]);
    
        Log::info('Mise à jour du taux de réduction.');
        Session::flash('success', 'Le taux de réduction a été mis à jour!');
        return redirect()->route('configRate');
    }
    

    

    public function showContracts()
    {
        $contrats_auto = DB::select('SELECT 
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
        where product_type=1 and users.id=user_id and auto_company.id=quotation.company_id and periode.id=assurance_auto_infos.periode and auto_infos.id=product_id and assurance_auto_infos.id=assurance_infos_id and quotation.status=5 order by quotation.id desc,nbmois desc');

        $contrats_voyage = DB::table('quotation')
                            ->join("users","users.id","quotation.user_id")
                            ->join("assurance_voyage_infos","assurance_voyage_infos.id","quotation.assurance_infos_id")
                            ->join("auto_company","auto_company.id","quotation.company_id")
                            ->select("quotation.*","assurance_voyage_infos.*","quotation.id as qid","quotation.product_type","assurance_infos_id","firstname","lastname","contact","email","compname","complogo")
                            ->where([["quotation.status","=",5],["product_type","=",3]])
                            ->orderBy("quotation.id","desc")->get();
        
        $periodes = DB::table('periode')->get();
    	return view('Backoffice.backend.client.contracts')->with(['isActive'=>'clientmanager', 'contrats_auto'=>$contrats_auto,'contrats_voyage'=>$contrats_voyage,'periodes'=>$periodes]);
    }

    // public function renewContract(Request $request)
    // {
    //     $old_q = Quotation::where('id',$request->id_cont)->first();
    //     $old_assur_info = assuranceAutoInfos::where('id',$old_q->assurance_infos_id)->first();

    //     $assuranceAutoInfos =  new assuranceAutoInfos();
    //     $assuranceAutoInfos->guarante =  $old_assur_info->guarante;
    //     $assuranceAutoInfos->releasedate = Carbon::createFromFormat("d/m/Y", $request->get('newreleasedate'))->toDateString();
    //     $assuranceAutoInfos->periode = $request->get('periode');
    //     $assuranceAutoInfos->subscription_type = $old_assur_info->subscription_type;
    //     $assuranceAutoInfos->reduction_commerciale =0;
    //     $assuranceAutoInfos->save();



    //     $quotation = new Quotation();
    //     $quotation->product_id= $old_q->product_id;
    //     $quotation->assurance_infos_id = $assuranceAutoInfos->id;
    //     $quotation->user_id = $old_q->user_id;
    //     $quotation->status =1;
    //     $quotation->product_type=$old_q->product_type;
    //     $quotation->number_n = Quotation::get_unique_number();
    //     $quotation->company_id = $old_q->company_id;
    //     $quotation->service_opt = $old_q->service_opt;
    //     $quotation->delivery_location = $old_q->delivery_location;
    //     $quotation->phone_client = $old_q->phone_client;
    //     $quotation->renew_order = 1;
    //     $quotation->save();

    //     $this->saveOrderStatusActor($quotation);
    //     Log::writeInDB("Renouvelement de contrat Automobile. $old_assur_info->number_n ==> $quotation->number_n");
    //     return redirect()->route('devis.details', ['id' => $quotation->id,'aid'=>$assuranceAutoInfos->id]); 
    // }

    public function renewContract(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'newreleasedate' => 'required|date_format:d/m/Y',
            'periode' => 'required|integer', // Adjust validation as needed
        ]);
    
        // Find the existing quotation
        $old_q = Quotation::find($request->id_cont);
        if (!$old_q) {
            return redirect()->back()->withErrors('Quotation not found.');
        }
    
        // Find the associated insurance information
        $old_assur_info = AssuranceAutoInfo::find($old_q->assurance_infos_id);
        if (!$old_assur_info) {
            return redirect()->back()->withErrors('Insurance information not found.');
        }
    
        // Create new assurance info
        $assuranceAutoInfos = new AssuranceAutoInfo();
        $assuranceAutoInfos->guarante = $old_assur_info->guarante;
    
        try {
            // Parse and format the release date
            $assuranceAutoInfos->releasedate = Carbon::createFromFormat("d/m/Y", trim($request->newreleasedate))->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Invalid release date format.');
        }
    
        $assuranceAutoInfos->periode = $request->periode;
        $assuranceAutoInfos->subscription_type = $old_assur_info->subscription_type;
        $assuranceAutoInfos->reduction_commerciale = 0;
        $assuranceAutoInfos->save();
    
        // Create a new quotation
        $quotation = Quotation::create([
            'product_id' => $old_q->product_id,
            'assurance_infos_id' => $assuranceAutoInfos->id,
            'user_id' => $old_q->user_id,
            'status' => 1,
            'product_type' => $old_q->product_type,
            'number_n' => Quotation::get_unique_number(),
            'company_id' => $old_q->company_id,
            'service_opt' => $old_q->service_opt,
            'delivery_location' => $old_q->delivery_location,
            'phone_client' => $old_q->phone_client,
            'renew_order' => 1,
        ]);
    
        // Log and redirect
        $this->saveOrderStatusActor($quotation);
        Log::writeInDB("Renouvellement de contrat Automobile. {$old_assur_info->number_n} ==> {$quotation->number_n}");
    
        return redirect()->route('devis.details', ['id' => $quotation->id, 'aid' => $assuranceAutoInfos->id]);
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
        where quotation.id="'.$id_contrat.'" and users.id=user_id and auto_company.id=quotation.company_id and periode.id=assurance_auto_infos.periode and auto_infos.id=product_id and assurance_auto_infos.id=assurance_infos_id and quotation.status=5')[0];
        
        if($contrats) return json_encode($contrats); else echo 0;
    }
    

    public function showDetailsContrat($id_contrat)
    {
        $directory = public_path()."/back/assets/js/vendor/file-upload/server/php/uploads/files_client/file/thumbnail/";
    
        // Vérifier si le répertoire existe avant d'utiliser scandir
        if (!is_dir($directory)) {
            $filtered_files = []; // Aucun fichier si le répertoire n'existe pas
        } else {
            $files = scandir($directory);
            $filtered_files = array_filter($files, function($file) use ($id_contrat) {
                return strpos($file, $id_contrat."_") === 0;
            });
        }
    
        return view('Backoffice.backend.client.details-contrat')
            ->with(['isActive' => 'clientmanager', 'files' => $filtered_files]);
    }
    
}
