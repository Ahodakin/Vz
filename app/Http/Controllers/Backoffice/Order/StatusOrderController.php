<?php

namespace App\Http\Controllers\Backoffice\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Backoffice\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; 
class StatusOrderController extends Controller
{
    public function confirmDevis(Request $request)
    {
      $idcomp = $request->get('idcomp');
      $qid = $request->get('qid');
      $service = $request->get('service');
      $service= $this->format_service($service);
      $response = quotation::where('id', $qid)
          ->update([
            'company_id' => $idcomp,
            'status' =>1
           ]);  


      $q = quotation::where('id', $qid)->first();
       
      if($response)
      {
        $this->saveOrderStatusActor($q);
        echo 1;
      }
      else
      {
        echo 0;
      }
    }
    
    public function cancelCommande($qid)
    {
        try {
            Log::info("Tentative de suppression du contrat avec ID : " . $qid);
    
            // Vérifiez si le contrat existe avant de tenter une mise à jour
            $existingQuotation = Quotation::find($qid);
            if (!$existingQuotation) {
                Log::warning("Contrat non trouvé avec ID : " . $qid);
                return response()->json(['success' => false, 'message' => 'Contrat non trouvé.']);
            }
    
            $response = Quotation::where('id', $qid)->update([
                'status' => -1,
                'company_id' => 0
            ]);
    
            Log::info("Réponse de la mise à jour : " . json_encode($response));
    
            if ($response) {
                $q = Quotation::where('id', $qid)->first();
                $this->saveOrderStatusActor($q);
                return response()->json(['success' => true, 'message' => 'Contrat supprimé avec succès.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Aucune mise à jour effectuée.']);
            }
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression du contrat : ' . $e->getMessage() . ' sur la ligne ' . $e->getLine() . ' dans le fichier ' . $e->getFile());
            return response()->json(['success' => false, 'message' => 'Erreur interne! Contacter le webmaster.']);
        }
    }
    
    
    

    public function validateOrder(Request $request)
    {
      $status = $request->get('status');
      $qid = $request->get('qid');
      $response = quotation::where('id', $qid)
          ->update([
            'status' =>$status,
            'phone_client'=>$request->get('delivery_phone'),
            'delivery_location'=>$request->get('delivery_location'),
            'policy_number'=>$request->get('policy_number'),
            ]); 

          if($status==2){
            $this->sendOrderSMS($request);
            $name = Session::get('_name_sousc');
            $phone = Session::get('_phone_sousc');
            $password = Session::get('_password_sousc');
            
            if($password && $request->get('espace_perso')=="on"){
                $mon_sms = "CHER CLIENT, VOS ACCES DE CONNEXION A VOTRE ESPACE PERSO MONASSURANCE.CI SONT:\r\nLOGIN : (VOTRE NUMERO) \r\nMOT DE PASSE : $password \r\nACCEDEZ A VOTRE ESPACE POUR CONSULTER L'HISTORIQUE DE VOS DEVIS ET COMMANDE.";
                $this->sendSMSForAccountPassword($mon_sms,$phone);
                $p = str_replace(" ", "", $phone);
                DB::table('espace_perso_account')->where('phone_number', $p)->update([
                  'status'=>1
                ]);
            }elseif($request->get('espace_perso')=="on"){
                $p = str_replace(" ", "", $phone);
                $acc = DB::table('espace_perso_account')->where('phone_number',$p)->first();
                if($acc){
                    $mon_sms = "CHER CLIENT, ACCEDEZ A VOTRE ESPACE POUR CONSULTER L'HISTORIQUE DE VOS DEVIS ET COMMANDE.\r\nLOGIN : $phone";
                    $this->sendSMSForAccountPassword($mon_sms,$p);
                }
            }
          } 
        $q =  quotation::where('id', $qid)->first();
      if($status<=4){
        User::where('id', $q->user_id)->update(['usertype'=>1]);
      } 

      if($status==5){
        quotation::where('id', $qid)
          ->update([
            'inbox_amount' =>$request->get('amount_inbox'),
            ]);
      }

     
       $q =  quotation::where('id', $qid)->first();
      if($response)
      {
        $this->saveOrderStatusActor($q);
        echo 1;
      }
      else
      {
        echo 0;
      }
    }
}
