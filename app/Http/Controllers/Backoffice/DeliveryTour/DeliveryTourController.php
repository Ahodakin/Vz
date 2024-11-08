<?php

namespace App\Http\Controllers\Backoffice\DeliveryTour;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Backoffice\DeliveryTour;
use App\Models\Backoffice\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
class DeliveryTourController extends Controller
{
   

    public function startDeliveryTour($id)
    {
    	$u = DB::table('delivery_tour')
    		->where('id',$id)
    		->update(['delivery_tour_status'=>1]);
    	$g = DB::table('delivery_tour')->where('id',$id)->first();
        Log::Info("Demarage de la tournée de livraison $g->tour_number.");
    	return json_encode($g);
    }


    public function closeDeliveryTour($id_tour)
    {
    	$r = DB::table('delivery_tour')->where('id',$id_tour)->update([
    		'delivery_tour_status'=>2,
    		'updated_at'=>Carbon::now()
    	]);

    	return $r;
    }


    public function getDeliveryTour($id_tour)
    {
    	$tour = DB::table('delivery_tour')->where('id',$id_tour)->first();

    	return json_encode($tour);
    }

    public function ShowListOrderDeliveryToCash()
    {
        $prospects = waitingDelivery()->get();

        $deliveryTours = DeliveryTour::with('deliveryman')
            ->orderBy('id', 'desc')
            ->get();

        // Récupérer les utilisateurs administrateurs
        $adminUsers = User::where('usertype', 99)->get();

        // Passer les données à la vue
        return view('Backoffice.backend.order.delivery-tocash', [
            'prospects' => $prospects,
            'adminUsers' => $adminUsers,
            'delivery_tour' => $deliveryTours,
            'isActive' => 'encaisser'
        ]);
    }

    public function ShowDeliveryTourDetailsToCashPage($id_tour)
    {
        // Récupérer la tournée de livraison avec le livreur
        $delivery_tour = DeliveryTour::with('deliveryman')->find($id_tour);
    
        if (!$delivery_tour) {
            return redirect()->back()->with('error', 'Tournée non disponible.');
        }
    
        // Récupérer les prospects 
        $prospects = $delivery_tour->prospects()
            ->where('product_type', 1)
            ->with('user')
            ->orderBy('id', 'desc')
            ->get();
    
        // Récupérer les prospects de voyage
        $prospects_voyage = Quotation::with(['assuranceAutoInfo', 'user'])
            ->where('delivery_location', $delivery_tour->id)
            ->where('product_type', 3)
            ->get();
    
        return view('Backoffice.backend.order.details-deliverytour-tocash', [
            'delivery_tour' => $delivery_tour,
            'prospects' => $prospects,
            'prospects_voyage' => $prospects_voyage,
            'isActive' => 'encaisser'
        ]);
    }
    
    // public function ShowDeliveryTourDetailsToCashPage($id_tour)
    // {
    //     // Récupérer la tournée de livraison avec le livreur
    //     $delivery_tour = DeliveryTour::with('deliveryman')->findOrFail($id_tour);
    
    //     // Récupérer les prospects 
    //     $prospects = $delivery_tour->prospects()
    //         ->where('product_type', 1)
    //         ->with('user')
    //         ->orderBy('id', 'desc')
    //         ->get();
    
    //     // Récupérer les prospects de voyage
    //     $prospects_voyage = Quotation::with(['assuranceAutoInfo', 'user'])
    //         ->where('delivery_location', $delivery_tour->id)
    //         ->where('product_type', 3)
    //         ->get();
    
    //     return view('Backoffice.backend.order.details-deliverytour-tocash', [
    //         'delivery_tour' => $delivery_tour,
    //         'prospects' => $prospects,
    //         'prospects_voyage' => $prospects_voyage,
    //         'isActive' => 'encaisser'
    //     ]);
    // }

    public function DeliveryTourSignaturePdf($id_sign)
    {
        $signature = DB::table('delivery_signature')
        ->join('delivery_tour','id_tour','delivery_tour.id')
        ->select("delivery_signature.*","delivery_tour.title","delivery_tour.tour_number")
        ->where('id_sign',$id_sign)->first();
        $deliveryman = getUserInfos($signature->id_deliveryman);
        $financial = getUserInfos($signature->id_financial);
        $operation = getUserInfos($signature->id_operation);

        $allOrders = DB::table('quotation')
                    ->join('delivery_tour_order', 'delivery_tour_order.order_id', 'quotation.id')
                    ->join('delivery_tour', 'delivery_tour_order.delivery_tour_id', 'delivery_tour.id')
                    ->join('users', 'users.id', 'quotation.user_id')
                    ->select('firstname', 'lastname', 'number_n','inbox_amount')
                    ->where('tour_number', $signature->tour_number)
                    ->get();

        $pdf = PDF::loadView('Backoffice.backend.pdf.auto.decharge', compact('signature','deliveryman','financial','operation', 'allOrders'));
        return $pdf->stream();

    }

    public function orderNotDelivery(Request $req)
    {

    	DB::table('quotation')->where('id',$req->get('order_id'))->update([
    		'status'=>2,
    		'updated_at'=>Carbon::now()
    	]);

    	$this->saveOrderStatusActor($req->get('order_id'),2);

    	DB::table('delivery_tour_order')->where('id',$req->get('delivery_order_id'))->update([
    		'delivery_status'=>-1,
    		'observation'=>$req->get('obs'),
    		'updated_at'=>Carbon::now()
    	]);

    	return redirect()->back();

    	
    }
    
      public function ShowListOrderWaitingDeliveryPage()
    {
        // Récupérer les prospects en attente de livraison
        $prospects = waitingDelivery()->get();

        // Récupérer les tournées de livraison avec les livreurs
        $delivery_tour = DeliveryTour::with('deliveryman')
            ->orderBy('id', 'desc')
            ->get();

        // Récupérer les administrateurs
        $adminUsers = User::where('usertype', 99)->get();

        // Passer les données à la vue
        return view('Backoffice.backend.order.delivery-management', [
            'prospects' => $prospects,
            'adminUsers' => $adminUsers,
            'delivery_tour' => $delivery_tour,
            'isActive' => 'deliveryman'
        ]);
    }


    public function ShowDeliveryTourDetailsPage($id_tour)
    {
        // Récupérer la tournée de livraison avec le livreur
        $delivery_tour = DeliveryTour::with('deliveryman')
            ->findOrFail($id_tour);

        // Récupérer les prospects (devis) pour le produit type 'Auto'
        $prospects = $delivery_tour->prospects()->where('product_type', 1)->get();

        // Récupérer les prospects (devis) pour le produit type 'Voyage'
        $prospects_voyage = Quotation::with(['assuranceAutoInfo', 'user', 'city']) 
            ->where('delivery_location', $delivery_tour->id)
            ->where('product_type', 3)
            ->get();

        // Retourner la vue avec les données
        return view('Backoffice.backend.order.details-deliverytour', compact('delivery_tour', 'prospects', 'prospects_voyage'))
            ->with(['isActive' => 'deliveryman']);
    }

    public function ShowDeliveryTourOperationDetailsPage($id_tour)
    {
        $delivery_tour = DB::table('delivery_tour')
        ->join('users','users.id','delivery_tour.deliveryman_id')
        ->select('delivery_tour.*','firstname','lastname')->where('delivery_tour.id',$id_tour)->first();

        /*Auto*/
        $prospects = DB::select('SELECT number_n,policy_number,priority, firstname,lastname, contact, email, usertype, product_type, quotation.status, inbox_amount, quotation.id as qid,assurance_auto_infos.periode as periode_id, assurance_auto_infos.releasedate as priseeffet, periode.nbmois, company_id, auto_infos.id as auto_id, users.id as user_id, delivery_status, delivery_tour_order.id as id_delivery_tour_order, delivery_tour_id, order_id, delivery_location, quotation.created_at as date_created, assurance_auto_infos.id as aid FROM quotation,assurance_auto_infos,auto_infos,users,delivery_tour_order, periode WHERE users.id=user_id and periode.id=assurance_auto_infos.periode and auto_infos.id=product_id and product_type=1 and assurance_auto_infos.id=assurance_infos_id and users.usertype<>99 and order_id=quotation.id and delivery_tour_id='.$delivery_tour->id.'  order by qid desc, priority asc');

        $prospects_voyage = DB::table("quotation")
                    ->join("assurance_voyage_infos","assurance_voyage_infos.id","quotation.assurance_infos_id")
                    ->join("users","users.id","quotation.user_id")
                    ->join("pays","pays.pays_id","assurance_voyage_infos.destination_country")
                    ->join("delivery_tour_order","delivery_tour_order.order_id","quotation.id")
                    ->select("quotation.id as qid","assurance_infos_id as assur_voy_id","user_id","quotation.status","product_type","number_n","policy_number","priority","company_id","service_opt","delivery_location","inbox_amount","phone_client","renew_order","quotation.created_at","destination_country","current_addr","destination_addr","departure_date","arrival_date","nationality_id","passport_num","date_expire_passport","firstname","lastname","gender","dob","contact","email","usertype","pays.pays_name","pays.pays_code","pays.pays_zone","delivery_tour_order.id as id_delivery_tour_order","delivery_tour_id","order_id","delivery_status")
                    ->where(["delivery_tour_id"=>$delivery_tour->id,"product_type"=>3])->get();

        
        return view('Backoffice.backend.order.details-deliverytour-operation', compact('delivery_tour','prospects','prospects_voyage'))->with(['isActive'=> 'commande']);
    }


    public function createDeliveryTour(Request $request)
    {
        // $tourdate = Carbon::createFromFormat('d/m/Y', $request->get('tourdate'))->toDateString();
        $tourdate = Carbon::createFromFormat('d/m/Y', $request->get('tourdate'));


    	$tourtime = $request->get('tourtime');

    	if(strtotime($tourdate.' '.$tourtime<= strtotime(Carbon::now()))){
    		Session::flash('error','La date de debut de la tournée doit être supérieur à la date et heure actuelle');
    		return redirect()->back();

    	}

        $tour_number = $this->get_unique_tour_number();

    	$deliveryTourId = DB::table('delivery_tour')->insertGetId([
    		'title' => $request->get('title'),
    		'tour_number' => $tour_number,
    		'tour_start_date' => $tourdate.' '.$tourtime,
    		'deliveryman_id'=>$request->get('deliveryman'),
    		'delivery_tour_status'=>0,
    		'created_at'=>Carbon::now(),
    		'updated_at'=>Carbon::now()
    	]);

    	if($request->get('tour_route') != null){
    		foreach ($request->get('tour_route') as  $t_r) {
    			DB::table('delivery_tour_route')->insert([
    				'delivery_tour_id'=>$deliveryTourId,
    				'commune_id'=>$t_r,
    				'created_at'=>Carbon::now(),
    				'updated_at'=>Carbon::now()
    			]);
    		}	
    	}

    	/*if($request->get('tour_order') != null){
    		foreach ($request->get('tour_order') as $key => $t_o) {
    			DB::table('	delivery_tour_order')->insert([
    				'delivery_tour_id'=>$deliveryTourId,
    				'order_id'=>$t_o,
    				'deliveryman_id'=>$request->get('deliveryman'),
    				'created_at'=>Carbon::now(),
    				'updated_at'=>Carbon::now()
    			]);
    		}	
    	}*/

        Log::Info("Création de la tournée de livraison $tour_number.");
    	return redirect()->back();
    }

    public function updateDeliveryTour(Request $request)
    {
    	$tourdate = Carbon::createFromFormat("d/m/Y", $request->get('tourdate'))->toDateString();


    	$tourtime = $request->get('tourtime');

    	if(strtotime($tourdate.' '.$tourtime<= strtotime(Carbon::now()))){
    		Session::flash('error','La date de debut de la tournée doit être supérieur à la date et heure actuelle');
    		return redirect()->back();

    	}

    	$deliveryTourId = DB::table('delivery_tour')->where('id',$request->get('idtour'))->update([
    		'title' => $request->get('title'),
    		'tour_start_date' => $tourdate.' '.$tourtime,
    		'deliveryman_id'=>$request->get('deliveryman'),
    		'delivery_tour_status'=>0,
    		'updated_at'=>Carbon::now()
    	]);

    	if($request->get('tour_route') != null){
    		DB::table('delivery_tour_route')->where('delivery_tour_id',$request->get('idtour'))->delete();
    		foreach ($request->get('tour_route') as  $t_r) {
    			DB::table('delivery_tour_route')->insert([
    				'delivery_tour_id'=>$request->get('idtour'),
    				'commune_id'=>$t_r,
    				'created_at'=>Carbon::now(),
    				'updated_at'=>Carbon::now()
    			]);
    		}	
    	}
        $tour = DB::table('delivery_tour')->where('id',$request->get('idtour'))->first();
        Log::writeInDB("Modification de la tournée de livraison $tour->tour_number.");

    	return redirect()->back();
    }

    public function setOrderToDeliveryTour(Request $request)
    {
    	if($request->get('tour_order') != null){
    		foreach ($request->get('tour_order') as $key => $t_o) {
    			DB::table('delivery_tour_order')->insert([
    				'delivery_tour_id'=>$request->get('tour'),
    				'order_id'=>$t_o,
    				'created_at'=>Carbon::now(),
    				'updated_at'=>Carbon::now()
    			]);
    		}
    	}
        $tour = DB::table('delivery_tour')->where('id',$request->get('tour'))->first();
        Log::Info("Affectation de commande à la tournée de livraison $tour->tour_number.");
    	return redirect()->back();
    }
    private function get_unique_tour_number()
    {
        // Récupérer la dernière tournée en fonction de l'ID pour incrémenter le numéro
        $lastTour = DB::table('delivery_tour')->orderBy('id', 'desc')->first();
        
        // Incrémenter l'ID pour obtenir le prochain numéro unique
        $chiffre = $lastTour ? $lastTour->id + 1 : 1;
        
        // Construire le numéro de tournée avec l'ID et la date actuelle
        $number = $chiffre . '-' . date('dmY');
    
        // Vérifier l'unicité du numéro de tournée généré
        $exists = DB::table('delivery_tour')->where('tour_number', $number)->exists();
        
        // Si le numéro existe déjà, rappeler la méthode pour en générer un nouveau
        if ($exists) {
            return $this->get_unique_tour_number();
        }
        
        // Retourner le numéro de tournée en majuscules
        return strtoupper($number);
    }
    

}
