<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

if(!function_exists('garantie_to_array'))
{
   function garantie_to_array($guarantee)
   {

     $result = substr($guarantee->guarante, 1, -1);
     $guarantees_array = explode(',', $rest);
     return $guarantees_array;

   }
}

if(!function_exists('getAllDeliveryTours'))
{
   function getAllDeliveryTours()
   {
      $x  = DB::table('delivery_tour')
      ->join('users','users.id','delivery_tour.deliveryman_id')
      ->where('delivery_tour_status','<>',2)
      ->select('delivery_tour.*','firstname','lastname')->get();
       

     return $x;

   }
}

if(!function_exists('getListOfOrderByDeliveryId'))
{
  function getListOfOrderByDeliveryId($id_tour)
  {    
    $delivery_tour_order = DB::table('delivery_tour_order')
    ->join('quotation','quotation.id','delivery_tour_order.order_id')
    ->select('delivery_tour_order.*','quotation.number_n','quotation.policy_number','quotation.status')
    ->where('delivery_tour_id',$id_tour)->get();
      $content ="";
     foreach ($delivery_tour_order as $del_tour_ord) {
       $content .='<label class="label label-info">'.$del_tour_ord->number_n.'</label>&nbsp;';
     }

     return $content;
  }
}

if(!function_exists('getUserDeliveryTours'))
{
   function getUserDeliveryTours()
   {
      $x  = DB::table('delivery_tour')
      ->join('users','users.id','delivery_tour.deliveryman_id')
      ->where([['users.id','=',Auth::user()->id],['delivery_tour_status','<>',2]])
      ->select('delivery_tour.*','firstname','lastname')->get();
       

     return $x;

   }
}
if(!function_exists('getQuoteInfos'))
{
   function getQuoteInfos($auto_info_id, $uid, $assurance_auto_info_id)
   {
    $quote = DB::table('quotation')
                ->where(['assurance_infos_id'=>$assurance_auto_info_id,'user_id'=>$uid,'product_id'=>$auto_info_id])
                ->first();
    if($quote){   
      if($quote->collect_data==null){
        $quotations = json_decode(app('App\Http\Controllers\Quotation\AutoQuotationController')->caculAutoQuotationFromDb($auto_info_id, $uid, $assurance_auto_info_id));
      }else{
        $quotations = json_decode($quote->collect_data);
      }
    }else{
      $quotations= [];
    }
     return $quotations;

   }
}
if(!function_exists('getListOfRouteByDeliveryId'))
{
  function getListOfRouteByDeliveryId($id_tour)
  {    
    $delivery_tour_route = DB::table('delivery_tour_route')
      ->join('commune','commune.id','delivery_tour_route.commune_id')
      ->select('delivery_tour_route.*','commune.commune')->where('delivery_tour_id',$id_tour)->get();

      $content ="";
     foreach ($delivery_tour_route as $del_tour_rou) {
       $content .= '<label class="label label-info">'.$del_tour_rou->commune.'</label>&nbsp;';
     }

     return $content;
  }
}

if(!function_exists('getListOfOrderByDeliveryIdAdvanced'))
{
  function getListOfOrderByDeliveryIdAdvanced($id_tour)
  {    
    $delivery_tour_order = DB::table('delivery_tour_order')
    ->join('quotation','quotation.id','delivery_tour_order.order_id')
    ->join('users','users.id','quotation.user_id')
    ->select('delivery_tour_order.*','quotation.number_n','quotation.policy_number','quotation.status','users.firstname','users.lastname')
    ->where('delivery_tour_id',$id_tour)->get();

      $content ="";
     foreach ($delivery_tour_order as $del_tour_ord) {
       $content .='<a href="'.route('deleteOrderToDeliveryTour',$del_tour_ord->order_id).'"><i class="fa fa-times"></i></a> - <label class="label label-info">'.$del_tour_ord->number_n.'</label><br/>';
     }

     return $content;
  }
}

if(!function_exists('waitingDelivery'))
{
   function waitingDelivery($start=null, $end=null)
   {
      if($start==null && $end==null)
      $x = DB::table('quotation')
                      ->join('users','users.id','=','quotation.user_id')
                      ->select('quotation.id as qid','quotation.number_n','quotation.policy_number','quotation.priority','quotation.product_type','quotation.status','quotation.created_at','quotation.delivery_location','quotation.phone_client','firstname','lastname','contact')
                      ->where('quotation.status','=',3);
        else
          $x = DB::table('quotation')
                          ->join('users','users.id','=','quotation.user_id')
                          ->select('quotation.id as qid','quotation.number_n','quotation.policy_number','quotation.priority','quotation.product_type','quotation.status','quotation.created_at','quotation.delivery_location','quotation.phone_client','firstname','lastname','contact')
                          ->where('quotation.status','=',3)
                          ->whereBetween("quotation.created_at",array($start, $end));

     return $x;

   }
}

if(!function_exists('orderToTrait'))
{
   function orderToTrait()
   {
    $commandes = DB::table('quotation')
                      ->join('users','users.id','=','quotation.user_id')
                      ->where('quotation.status','=',4);

    return $commandes;
       }
}



if(!function_exists('get_porcentage_red_permis'))
{
   function get_porcentage_red_permis($mise_circ)
   {
       $date_perm = explode('-', $mise_circ);
      $ageVehicule = \Carbon\Carbon::createFromDate($date_perm[0], $date_perm[1], $date_perm[2])->diff(\Carbon\Carbon::now())->format('%y');
      if(intval($ageVehicule)>=2){
        return 5;  
      }else{
         return 0;  
      }
   }
}

if (!function_exists('getDeliveryTourIdByOrderId')) {
  function getDeliveryTourIdByOrderId($order_id)
  {
      $x = DB::table('delivery_tour_order')
          ->where('order_id', '=', $order_id)
          ->first();

      if ($x === null) {
          // Optionnel : Loguer l'erreur pour le diagnostic
          Log::error("Aucune tournée trouvée pour l'ID de commande : $order_id");
          return null; // Ou une valeur par défaut, par exemple 0
      }

      return $x->delivery_tour_id;
  }
}


if(!function_exists('getCountryById'))
{
   function getCountryById($id)
   {
    $pays = DB::table('pays')->where('pays_id','=',$id)->first();
    if($pays)
      return $pays->pays_name;
    else
      "N/A";
  }
}

if(!function_exists('tourIsSignature'))
{
   function tourIsSignature($id_tour)
   {
      $x = DB::table('delivery_signature')
        ->where('id_tour','=',$id_tour)->count();
       
      if($x==0) return false;else return true;
   

   }
}

if(!function_exists('getTourSignature'))
{
   function getTourSignature($id_tour)
   {
      $x = DB::table('delivery_signature')
        ->where('id_tour','=',$id_tour)->first();
       
      return $x;
   

   }
}

if(!function_exists('getUserInfos'))
{
   function getUserInfos($user_id)
   {
      $x  = DB::table('users')
      ->where('id',$user_id)->first(); 
     return $x;

   }
}

if(!function_exists('dateDiff')){
  function dateDiff($date1, $date2){
    $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
    $retour = array();
 
    $tmp = $diff;
    $retour['second'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['second']) /60 );
    $retour['minute'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['minute'])/60 );
    $retour['hour'] = $tmp % 24;
 
    $tmp = floor( ($tmp - $retour['hour'])  /24 );
    $retour['day'] = $tmp;
 
    return $retour;
  }
}
if(!function_exists('dateAgo'))
{
   function dateAgo($date)
   {
    $retour = dateDiff(time(), strtotime($date));
    $heures = $retour['hour'];
    $minutes = $retour['minute'];
    $secondes = $retour['second'];
    $jours = $retour['day'];
      if($minutes == 0)
        $text = "A l'instant";
      else
        $text = "Dépuis ". $minutes . " minutes(s)";

      if($heures>=1) $text =  "Il y a ". $heures . " heure(s)";  

      if($jours>=1)   $text =  "Il y a ". $jours . " jour(s)";
      

      return $text;

   }
}if(!function_exists('activeSinistre'))
{
   function activeSinistre()
   { 
     $sinistres = DB::table('sinistre')->where('sin_manager',null)->get();
     return $sinistres;

   }
}

if(!function_exists('getCountryById'))
{
   function getCountryById($id)
   {
    $pays = DB::table('pays')->where('pays_id','=',$id)->first();
    if($pays)
      return $pays->pays_name;
    else
      "N/A";
  }
}

if(!function_exists('getCarColor'))
{
   function getCarColor($id_color)
   {

     if($id_color==1){
      $color="Blanc";
     }
     elseif($id_color==2){
      $color="Bleu";
     }
     elseif($id_color==3){
      $color="Gris";
     }
     elseif($id_color==4){
      $color="Jaune";
     }
     elseif($id_color==5){
      $color="Maron";
     }
     elseif($id_color==6){
      $color="Noir";
     }
     elseif($id_color==7){
      $color="Orange";
     }
     elseif($id_color==8){
      $color="Rouge";
     }
     elseif($id_color==9){
      $color="Vert";
     }
     elseif($id_color==10){
      $color="Violet";
     }else{
      $color="Autres";
     }
     return $color;

   }
}

if(!function_exists('getCylindree'))
{
   function getCylindree($id)
   {

     if($id==1){
      $cyl="0-50";
     }
     elseif($id==2){
      $cyl="51-99";
     }
     elseif($id==3){
      $cyl="100-175";
     }
     elseif($id==4){
      $cyl="176-350";
     }
     elseif($id_color==5){
      $cyl="Plus de 350";
     }
     else{
      $cyl="--";
     }
     return $cyl;

   }
}



if(!function_exists('test'))
{
   function test()
   {

     $a = "testmoi";
     return $a;

   }
}

if(!function_exists('get_users_status'))
{
   function get_users_status($user_status)
   {
     if($user_status==0)
    {
      return 'Prospect';
    }
    elseif($user_status==1)
    {
       return 'Client';
    }
    elseif($user_status==99)
    {
        return 'Aroli';
    }
    elseif($user_status==-1)
    {
        return 'Banni';
    }
    else{
      return 'N/A';
    }
    
   }
}

if(!function_exists('get_commande_status'))
{
   function get_commande_status($status)
   {
     if($status==0)
    {
      return '<span class="label label-warning">Dévis/Proposition</span>';
    }
    elseif($status==1)
    {
       return '<span class="label label-info">Dévis choisi</span>';
    }
    elseif($status==2)
    {
        return '<span class="label label-info">En cours de traitement</span>';
    }
    elseif($status==3)
    {
        return '<span class="label label-info">En attente de livraison</span>';
    }
     elseif($status==4)
    {
        return '<span class="label label-warning">Livrée (à encaisser)</span>';
    }
    elseif($status==5)
    {
        return '<span class="label label-success">Terminée</span>';
    }
     elseif($status==-1)
    {
        return '<span class="label label-danger">Annulée</span>';
    }
   }
}


if(!function_exists('get_commande_status_by_text'))
{
   function get_commande_status_by_text($status)
   {
     if($status==0)
    {
      return 'Dévis/Proposition';
    }
    elseif($status==1)
    {
       return 'Dévis Choisi';
    }
    elseif($status==2)
    {
        return 'En cours de traitement';
    }
    elseif($status==3)
    {
       return 'En attente de livraison';
    }
    elseif($status==4)
    {
        return 'Livrée';
    }
     elseif($status==5)
    {
        return 'Terminée';
    }
     elseif($status==-1)
    {
        return 'Annulée';
    }

   }
}

if(!function_exists('get_pdf_label'))
{
   function get_pdf_label($status)
   {
     if($status==0)
    {
      return 'Dévis';
    }
    elseif($status==1)
    {
       return 'Proposition';
    }
    elseif($status==2)
    {
        return 'Commande';
    }
    elseif($status==3)
    {
       return 'Commande';
    }
    elseif($status==4)
    {
        return 'Police';
    }
     elseif($status==5)
    {
        return 'Police';
    }
     elseif($status==-1)
    {
        return 'Commande';
    }

   }
}




if(!function_exists('get_detail_action_by_status'))
{
   function get_detail_action_by_status($status)
   {
     if($status==0)
    {
      return ' <a href="#" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20" data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></a>';
    }
    elseif($status==1)
    {
       return '<span class="label label-info">Validée</span>';
    }
    elseif($status==3)
    {
        return '<span class="label label-red">En attente de livrison</span>';
    }
    else if($status==4)
    {
        return '<span class="label label-success">Livré Payé</span>';
    }
     else if($status==-1)
    {
        return '<span class="label label-danger">Annulé</span>';
    }

   }
}


if(!function_exists('get_commande_action'))
{
   function get_commande_action($status,$lien)
   {
     
      return '<a href="'.$lien.'" class="btn btn-xs btn-default"><i class="fa fa-search"></i> voir</a>';
    

   }
}

if(!function_exists('newCallAlert'))
{
   function newCallAlert()
   {

     $active_call_me = DB::table('callme_log')->where('advisor_user_id','=',0)->get();

     return $active_call_me;

   }
}


if(!function_exists('newDevis'))
{
   function newDevis($start=null, $end=null)
   {
    if($start==null && $end==null)
      $confirm_1 =DB::table('quotation')
                        ->join('users','users.id','=','quotation.user_id')
                        ->select('quotation.*',"assurance_infos_id as aid")
                        ->where('quotation.status','=',1)->get();
    else
      $confirm_1 =DB::table('quotation')
                          ->join('users','users.id','=','quotation.user_id')
                          ->select('quotation.*',"assurance_infos_id as aid")
                          ->where('quotation.status','=',1)
                          ->whereBetween("quotation.created_at",array($start, $end))->get();

     return $confirm_1;

   }
}

if(!function_exists('get_sinistre_status'))
{
   function get_sinistre_status($status)
   {
     if($status==0)
    {
      return '<label class="label label-info">Sinistre déclaré</label>';
    }
    elseif($status==1)
    {
       return '<label class="label label-info">Documents collectés</label>';
    }
    elseif($status==2)
    {
        return '<label class="label label-info">Dossier transmis au service réseau de la compagnie</label>';
    }
    else{
      return '<label class="label label-info">Sinitre classé</label>';
    }
    
   }
}

if(!function_exists('get_sinistre_decision'))
{
   function get_sinistre_decision($status)
   {
     if($status==0)
    {
      return '<label class="label label-info">En cours</label>';
    }
    elseif($status==1)
    {
       return '<label class="label label-success">Reglé</label>';
    }
    else
    {
        return '<label class="label label-danger">Non réglé</label>';
    }
    
   }
}



if(!function_exists('getCarColor'))
{
   function getCarColor($id_color)
   {

     if($id_color==1){
      $color="Blanc";
     }
     elseif($id_color==2){
      $color="Bleu";
     }
     elseif($id_color==3){
      $color="Gris";
     }
     elseif($id_color==4){
      $color="Jaune";
     }
     elseif($id_color==5){
      $color="Maron";
     }
     elseif($id_color==6){
      $color="Noir";
     }
     elseif($id_color==7){
      $color="Orange";
     }
     elseif($id_color==8){
      $color="Rouge";
     }
     elseif($id_color==9){
      $color="Vert";
     }
     elseif($id_color==10){
      $color="Violet";
     }else{
      $color="Autres";
     }
     return $color;

   }
}

if(!function_exists('get_product_type'))
{
   function get_product_type($id_product)
   {
     if($id_product==1)
    {
      return 'Automobile';
    }
    elseif($id_product==2)
    {
       return 'Habitation';
    }
    elseif($id_product==3)
    {
        return 'Voyage';
    }
    else{
      return 'Responsabilité civile';
    }
    
   }
}

if(!function_exists('get_users_status'))
{
   function get_users_status($user_status)
   {
     if($user_status==0)
    {
      return 'Prospect';
    }
    elseif($user_status==1)
    {
       return 'Client';
    }
    elseif($user_status==99)
    {
        return 'Aroli';
    }
    elseif($user_status==-1)
    {
        return 'Banni';
    }
    else{
      return 'N/A';
    }
    
   }
}

if(!function_exists('get_commande_status'))
{
   function get_commande_status($status)
   {
     if($status==0)
    {
      return '<span class="label label-warning">Dévis/Proposition</span>';
    }
    elseif($status==1)
    {
       return '<span class="label label-info">Dévis choisi</span>';
    }
    elseif($status==2)
    {
        return '<span class="label label-info">En cours de traitement</span>';
    }
    elseif($status==3)
    {
        return '<span class="label label-info">Mise livraison</span>';
    }
     elseif($status==4)
    {
        return '<span class="label label-warning">Livrée (à encaisser)</span>';
    }
    elseif($status==5)
    {
        return '<span class="label label-success">Terminée</span>';
    }
     elseif($status==-1)
    {
        return '<span class="label label-danger">Annulée</span>';
    }
   }
}

if(!function_exists('get_commande_percentage'))
{
   function get_commande_percentage($status)
   {
     if($status==0)
    {
      return '5';
    }
    elseif($status==1)
    {
       return '10';
    }
    elseif($status==2)
    {
        return '25';
    }
    elseif($status==3)
    {
       return '50';
    }
    elseif($status==4)
    {
        return '75';
    }
     elseif($status==5)
    {
        return '100';
    }
     elseif($status==-1)
    {
        return '0';
    }

   }
}

if(!function_exists('get_commande_status_by_text'))
{
   function get_commande_status_by_text($status)
   {
     if($status==0)
    {
      return 'Dévis/Proposition';
    }
    elseif($status==1)
    {
       return 'Dévis Choisi';
    }
    elseif($status==2)
    {
        return 'En cours de traitement';
    }
    elseif($status==3)
    {
       return 'Mise en livraison';
    }
    elseif($status==4)
    {
        return 'Livrée';
    }
     elseif($status==5)
    {
        return 'Terminée';
    }
     elseif($status==-1)
    {
        return 'Annulée';
    }

   }
}

if(!function_exists('get_pdf_label'))
{
   function get_pdf_label($status)
   {
     if($status==0)
    {
      return 'Dévis';
    }
    elseif($status==1)
    {
       return 'Proposition';
    }
     else
    {
        return 'Commande';
    }

   }
}


if(!function_exists('get_detail_action_by_status'))
{
   function get_detail_action_by_status($status)
   {
     if($status==0)
    {
      return ' <a href="#" class="btn btn-ef btn-ef-1 btn-ef-1-default btn-ef-1a btn-rounded-20" data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></a>';
    }
    elseif($status==1)
    {
       return '<span class="label label-info">Validée</span>';
    }
    elseif($status==3)
    {
        return '<span class="label label-red">En attente de livrison</span>';
    }
    else if($status==4)
    {
        return '<span class="label label-success">Livré Payé</span>';
    }
     else if($status==-1)
    {
        return '<span class="label label-danger">Annulé</span>';
    }

   }
}


if(!function_exists('get_commande_action'))
{
   function get_commande_action($status,$lien)
   {     
      return '<a href="'.$lien.'" class="btn btn-xs btn-default"><i class="fa fa-search"></i> voir</a>';
   }
}

if(!function_exists('waitingTraitement'))
{
   function waitingTraitement($start=null, $end=null)
   {
      if($start==null && $end==null)
      $x = DB::table('quotation')
                      ->join('users','users.id','=','quotation.user_id')
                      ->select('quotation.*')
                      ->where('quotation.status','=',2);
      else
        $x = DB::table('quotation')
                        ->join('users','users.id','=','quotation.user_id')
                        ->select('quotation.*')
                        ->where('quotation.status','=',2)
                        ->whereBetween("quotation.created_at",array($start, $end));

     return $x;

   }
}

if(!function_exists('waitingDelivery'))
{
   function waitingDelivery($start=null, $end=null)
   {
      if($start==null && $end==null)
      $x = DB::table('quotation')
                      ->join('users','users.id','=','quotation.user_id')
                      ->select('quotation.id as qid','quotation.number_n','quotation.policy_number','quotation.priority','quotation.product_type','quotation.status','quotation.created_at','quotation.delivery_location','quotation.phone_client','firstname','lastname','contact')
                      ->where('quotation.status','=',3);
        else
          $x = DB::table('quotation')
                          ->join('users','users.id','=','quotation.user_id')
                          ->select('quotation.id as qid','quotation.number_n','quotation.policy_number','quotation.priority','quotation.product_type','quotation.status','quotation.created_at','quotation.delivery_location','quotation.phone_client','firstname','lastname','contact')
                          ->where('quotation.status','=',3)
                          ->whereBetween("quotation.created_at",array($start, $end));

     return $x;

   }
}

if(!function_exists('getListOfRouteByDeliveryId'))
{
  function getListOfRouteByDeliveryId($id_tour)
  {    
    $delivery_tour_route = DB::table('delivery_tour_route')
      ->join('commune','commune.id','delivery_tour_route.commune_id')
      ->select('delivery_tour_route.*','commune.commune')->where('delivery_tour_id',$id_tour)->get();

      $content ="";
     foreach ($delivery_tour_route as $del_tour_rou) {
       $content .= '<label class="label label-info">'.$del_tour_rou->commune.'</label>&nbsp;';
     }

     return $content;
  }
}

if(!function_exists('getListOfOrderByDeliveryId'))
{
  function getListOfOrderByDeliveryId($id_tour)
  {    
    $delivery_tour_order = DB::table('delivery_tour_order')
    ->join('quotation','quotation.id','delivery_tour_order.order_id')
    ->select('delivery_tour_order.*','quotation.number_n','quotation.policy_number','quotation.status')
    ->where('delivery_tour_id',$id_tour)->get();
      $content ="";
     foreach ($delivery_tour_order as $del_tour_ord) {
       $content .='<label class="label label-info">'.$del_tour_ord->number_n.'</label>&nbsp;';
     }

     return $content;
  }
}

if(!function_exists('newProposition'))
{
   function newProposition()
  {
    $prospects = DB::select('SELECT number_n,policy_number,priority, firstname,lastname, product_type,product_id, quotation.status, quotation.id as qid,assurance_infos_id as aid, quotation.user_id, quotation.created_at as date_created FROM quotation,users WHERE users.id=user_id and quotation.status<=4 and users.usertype<>99 and quotation.view=0 order by qid desc, priority asc');
    
      return $prospects;
  }
}

if(!function_exists('getListOfOrderByDeliveryIdAdvanced'))
{
  function getListOfOrderByDeliveryIdAdvanced($id_tour)
  {    
    $delivery_tour_order = DB::table('delivery_tour_order')
    ->join('quotation','quotation.id','delivery_tour_order.order_id')
    ->join('users','users.id','quotation.user_id')
    ->select('delivery_tour_order.*','quotation.number_n','quotation.policy_number','quotation.status','users.firstname','users.lastname')
    ->where('delivery_tour_id',$id_tour)->get();

      $content ="";
     foreach ($delivery_tour_order as $del_tour_ord) {
       $content .='<a href="'.route('deleteOrderToDeliveryTour',$del_tour_ord->order_id).'"><i class="fa fa-times"></i></a> - <label class="label label-info">'.$del_tour_ord->number_n.'</label><br/>';
     }

     return $content;
  }
}



if(!function_exists('deliveriedOrder'))
{
   function deliveriedOrder($start=null, $end=null)
   {
      if($start==null && $end==null)
      $x = DB::table('quotation')
                      ->join('users','users.id','=','quotation.user_id')
                      ->where('quotation.status','=',4);
      else
        $x = DB::table('quotation')
                        ->join('users','users.id','=','quotation.user_id')
                        ->where('quotation.status','=',4)
                        ->whereBetween("quotation.created_at",array($start, $end));

     return $x;

   }
}

if(!function_exists('completedOrder'))
{
   function completedOrder($start=null, $end=null)
   {
      if($start==null && $end==null)
      $x = DB::table('quotation')
                      ->join('users','users.id','=','quotation.user_id')
                      ->where('quotation.status','=',5);
      else
        $x = DB::table('quotation')
                      ->join('users','users.id','=','quotation.user_id')
                      ->where('quotation.status','=',5)
                      ->whereBetween("quotation.created_at",array($start, $end));

     return $x;

   }
}

if(!function_exists('newOrder'))
{
   function newOrder($start=null, $end=null)
   {  
      if($start==null && $end==null)
      $x = DB::table('quotation')
                      ->join('users','users.id','=','quotation.user_id')
                      ->where([['quotation.status','>=',3],['quotation.status','<',4]]);
      else
        $x = DB::table('quotation')
                        ->join('users','users.id','=','quotation.user_id')
                        ->where([['quotation.status','>=',3],['quotation.status','<',4]])
                        ->whereBetween("quotation.created_at",array($start, $end));

     return $x;

   }
}



if(!function_exists('canceledOrder'))
{
   function canceledOrder($start=null, $end=null)
   {
      if($start==null && $end==null)
      $x = DB::table('quotation')
                      ->join('users','users.id','=','quotation.user_id')
                      ->where('quotation.status','=',-1);
      else
        $x = DB::table('quotation')
                        ->join('users','users.id','=','quotation.user_id')
                        ->where('quotation.status','=',-1)
                        ->whereBetween("quotation.created_at",array($start, $end));

     return $x;

   }
}


// if(!function_exists('isOrderSetToDeliveryTour'))
// {
//    function isOrderSetToDeliveryTour($id_order)
//    {
//       $x = DB::table('delivery_tour_order')
//         ->join('delivery_tour','delivery_tour.id','delivery_tour_order.delivery_tour_id')
//         ->where([['order_id','=',$id_order]])->first();
//         if(sizeof($x)==1) return true; else return false;

//    }
// }
if (!function_exists('isOrderSetToDeliveryTour')) {
   function isOrderSetToDeliveryTour($id_order) {
      $x = DB::table('delivery_tour_order')
        ->join('delivery_tour', 'delivery_tour.id', 'delivery_tour_order.delivery_tour_id')
        ->where('order_id', '=', $id_order)
        ->first();

      return $x !== null; // Returns true if a record is found, otherwise false
   }
}


if(!function_exists('getDeliveryNumberForOrder'))
{
   function getDeliveryNumberForOrder($id_order)
   {
      $x = DB::table('delivery_tour_order')
        ->join('delivery_tour','delivery_tour.id','delivery_tour_order.delivery_tour_id')
        ->where([['order_id','=',$id_order]])->first();

     return $x;

   }
}

if(!function_exists('getDeliveryTourStatus'))
{
   function getDeliveryTourStatus($id_order)
   {
      $x = DB::table('delivery_tour')
        ->join('delivery_tour_order','delivery_tour_order.delivery_tour_id','delivery_tour.id')
        ->where([['order_id','=',$id_order]])->first();
       

     return $x;

   }
}
 