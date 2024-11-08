<?php

namespace App\Http\Controllers\Backoffice\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon; 


class EspacePersoController extends Controller
{
    public function showAllSpace()
    {
    	$users_space = DB::table('espace_perso_account')->where('status',1)->orderBy('id','desc')->get();
    	return view('Backoffice.backend.client/espace-perso')->with([
    		'isActive'=>'clientmanager',
    		'users_space'=>$users_space
    	]);
    }

    public function createNewSpace(Request $request)
    {
        $password = trim($request->default_password);
        $phone = str_replace(" ", "", $request->num_phone);
        $acc = DB::table('espace_perso_account')->where('phone_number',$phone)->first();
        if(!$acc){
            DB::table("espace_perso_account")->insert([
                    'name'=>$request->account_name,
                    'phone_number'=>$phone,
                    'password'=>bcrypt($password),
                    'status'=>1,
                    'remember_token' => Str::random(60),
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now()
            ]);
                
                
            $mon_sms = "CHER CLIENT, VOS ACCES DE CONNEXION A VOTRE ESPACE MONASSURANCE.CI SONT :\r\nLOGIN : $phone \r\nMOT DE PASSE : $password";
            $this->sendSMSForAccountPassword($mon_sms,$phone);

            Session::flash('success','Nouveau compte créé avec succès');

        }else{
            Session::flash('error','Un compte existe déja avec ce numéro de telephone');
        }
        return redirect()->back();
    }


    private function sendSMSForAccountPassword($mon_sms,$phone)
    {
        
        $sender_id = rawurlencode("220 170 00"); //Nombre de caractères inférieure à 11 (y compris les espaces)  
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("-", "", $phone);
        $url = "http://gateway2.arolitec.com/interface/senderv2.php?user=addams&password=wN44vu5Q&sender=".$sender_id."&receiver=225".$phone."&content=".urlencode($mon_sms);

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST =>"GET",
        CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache"
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    }

    public function resetPassword(Request $req)
    {
        $password = Str::random(6); // Utilisation de Str::random(6)
        if (is_numeric($req->id_space)) {
            DB::table('espace_perso_account')->where('id', $req->id_space)->update([
                'password' => bcrypt($password)
            ]);
            $p = str_replace(" ", "", $req->login);
            $acc = DB::table('espace_perso_account')->where('id', $req->id_space)->first();
            if ($acc) {
                $mon_sms = "CHER CLIENT, VOTRE MOT DE PASSE A ETE REINITIALISE.\r\nLOGIN : $p \r\nMOT DE PASSE : $password";
                $this->sendSMSForAccountPassword($mon_sms, $p);
            }
            Session::flash('success', 'Mot de passe réinitialisé avec succès');
        } else {
            Session::flash('error', 'Une erreur est survenue !!');
        }
    
        return redirect()->back();
    }
    

    public function deleteSpace($phone_number)
    {
        $p = str_replace(" ", "", $phone_number);
        $resp = DB::table('espace_perso_account')->where('phone_number', $p)->update([
          'status'=>-1
        ]);
        echo "success";
    }
}
