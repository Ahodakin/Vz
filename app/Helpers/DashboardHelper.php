<?php
use Illuminate\Support\Facades\DB;
use App\Models\Backoffice\Quotation; 
use App\Models\callMe; 

// app/helpers.php

if (!function_exists('isOrderSetToDeliveryTour')) {
   function isOrderSetToDeliveryTour($qid)
   {
       // Implement your logic here to check the delivery tour status
       // Example:
       return \App\Models\Backoffice\DeliveryTour::where('deliveryman_id', $qid)->exists();
   }
}


if (!function_exists('orderToTrait')) {
   function orderToTrait()
   {
       // Assuming you are querying the "quotation" table with related user details.
       return \DB::table('quotation')
           ->join('users', 'quotation.user_id', '=', 'users.id')
           ->where('quotation.status', '=', 'pending'); // Add any other necessary conditions
   }
}



if (!function_exists('isOrderSetToDeliveryTour')) {
   function isOrderSetToDeliveryTour($qid)
   {
       // Implement your logic here to check the delivery tour status
       // Example:
       return \App\Models\Backoffice\DeliveryTour::where('deliveryman_id', $qid)->exists();
   }
}


if (!function_exists('orderToTrait')) {
   function orderToTrait()
   {
       // Assuming you are querying the "quotation" table with related user details.
       return \DB::table('quotation')
           ->join('users', 'quotation.user_id', '=', 'users.id')
           ->where('quotation.status', '=', 'pending'); // Add any other necessary conditions
   }
}

if(!function_exists('getActiveAutoOrders'))
{
   function getActiveAutoOrders()
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
    user_id,
    assurance_auto_infos.id as aid,
    assurance_auto_infos.periode as ass_periode_id,
    assurance_auto_infos.guarante,
    assurance_auto_infos.releasedate,
    auto_company.id as comp_id,
    compname,
    complogo,
    matriculation,
    DATE_ADD(assurance_auto_infos.releasedate, INTERVAL periode.nbmois MONTH) as expired_date
    from 
    quotation,
    assurance_auto_infos,
    auto_infos,
    periode,
    auto_company,
    users
    where product_type=1 
    and DATE_ADD(quotation.created_at, INTERVAL periode.nbmois MONTH) > NOW() 
    and users.id=user_id 
    and auto_company.id=quotation.company_id 
    and periode.id=assurance_auto_infos.periode 
    and auto_infos.id=product_id 
    and assurance_auto_infos.id=assurance_infos_id 
    and quotation.status=5 
    order by DATE_ADD(quotation.created_at, INTERVAL periode.nbmois MONTH) asc');

   return $contrats_auto;
   }
}

if (!function_exists('newCallAlert')) {
   function newCallAlert()
   {
       return \App\Models\CallMe::where('advisor_conclusion', 1) 
                  ->where('created_at', '>=', now()->subHours(1)) 
                  ->get();
   // }
   // {  
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
    user_id,
    assurance_auto_infos.id as aid,
    assurance_auto_infos.periode as ass_periode_id,
    assurance_auto_infos.guarante,
    assurance_auto_infos.releasedate,
    auto_company.id as comp_id,
    compname,
    complogo,
    matriculation,
    DATE_ADD(assurance_auto_infos.releasedate, INTERVAL periode.nbmois MONTH) as expired_date
    from 
    quotation,
    assurance_auto_infos,
    auto_infos,
    periode,
    auto_company,
    users
    where product_type=1 
    and DATE_ADD(quotation.created_at, INTERVAL periode.nbmois MONTH) > NOW() 
    and users.id=user_id 
    and auto_company.id=quotation.company_id 
    and periode.id=assurance_auto_infos.periode 
    and auto_infos.id=product_id 
    and assurance_auto_infos.id=assurance_infos_id 
    and quotation.status=5 
    order by DATE_ADD(quotation.created_at, INTERVAL periode.nbmois MONTH) asc');

   return $contrats_auto;
   }
}

if (!function_exists('newCallAlert')) {
   function newCallAlert()
   {
       return \App\Models\CallMe::where('advisor_conclusion', 1) 
                  ->where('created_at', '>=', now()->subHours(1)) 
                  ->get();
   }
}





if(!function_exists('getAllReviveQuote'))
{
   function getAllReviveQuote($start=null, $end=null)
   {  
      if($start==null && $end==null)
      $revive = DB::table('revive_client_quotation')
      ->join('quotation','quotation.id','revive_client_quotation.quotation_id')
      ->join('users','users.id','quotation.user_id')
      ->select('quotation.id as qid','product_type','quotation.number_n','quotation.assurance_infos_id','firstname','lastname','advisor_note','revive_date','revive_client_quotation.created_at')
      ->where('revive_date','>=',DB::Raw('DATE(NOW())'))
      ->orderBy('revive_date','asc')
      ->get();
      else
     
     $revive = DB::table('revive_client_quotation')
      ->join('users','users.id','revive_client_quotation.admin_id')
      ->join('quotation','quotation.id','revive_client_quotation.quotation_id')
      ->select('quotation.id as qid','product_type','quotation.number_n','quotation.assurance_infos_id','firstname','lastname','advisor_note','revive_date','revive_client_quotation.created_at')
      ->where('revive_date','>=',DB::Raw('DATE(NOW())'))
      ->orderBy('revive_date','asc')
      ->whereBetween("revive_client_quotation.created_at",array($start, $end))
      ->get();

      return $revive;

   }
}

if(!function_exists('getSaleByAutoInsurType'))
{
   function getSaleByAutoInsurType($start=null, $end=null)
   {  
      if($start==null && $end==null)
      $sale = DB::table('quotation')->join('assurance_auto_infos','quotation.assurance_infos_id','assurance_auto_infos.id')->select('quotation.id as qid','quotation.status','assurance_auto_infos.guarante',DB::raw('count(quotation.id) as sales_nb'))->where('status',5)->groupBy('assurance_auto_infos.guarante')->orderBy('sales_nb','desc');
      else
     
      $sale = DB::table('quotation')->join('assurance_auto_infos','quotation.assurance_infos_id','assurance_auto_infos.id')->select('quotation.id as qid','quotation.status','assurance_auto_infos.guarante',DB::raw('count(quotation.id) as sales_nb'))->whereBetween("quotation.created_at",array($start, $end))->where('status',5)->groupBy('assurance_auto_infos.guarante')->orderBy('sales_nb','desc');

      return $sale;

   }
}

if(!function_exists('getQuoteByAutoInsurType'))
{
   function getQuoteByAutoInsurType($start=null, $end=null)
   {  
      if($start==null && $end==null)
      $quote = DB::table('quotation')->join('assurance_auto_infos','quotation.assurance_infos_id','assurance_auto_infos.id')->select('quotation.id as qid','quotation.status','assurance_auto_infos.guarante',DB::raw('count(quotation.id) as quote_nb'))->where([['status','<',5],['status','<>',-1]])->groupBy('assurance_auto_infos.guarante')->orderBy('quote_nb','desc');
      else
     
      $quote = DB::table('quotation')->join('assurance_auto_infos','quotation.assurance_infos_id','assurance_auto_infos.id')->select('quotation.id as qid','quotation.status','assurance_auto_infos.guarante',DB::raw('count(quotation.id) as quote_nb'))->whereBetween("quotation.created_at",array($start, $end))->where([['status','<',5],['status','<>',-1]])->groupBy('assurance_auto_infos.guarante')->orderBy('quote_nb','desc');

      return $quote;

   }
}



if(!function_exists('getSaleByCompany'))
{
   function getSaleByCompany($start=null, $end=null)
   {  
      if($start==null && $end==null)
      $comp = DB::table('auto_company')->join('quotation','quotation.company_id','auto_company.id')->select('auto_company.id as comp_id','compname','complogo','quotation.id as qid','quotation.status',DB::raw('count(quotation.id) as sales'))->where('status',5)->groupBy('auto_company.id')->orderBy('sales','desc');
      else
      $comp = DB::table('auto_company')->join('quotation','quotation.company_id','auto_company.id')->select('auto_company.id as comp_id','compname','complogo','quotation.id as qid','quotation.status',DB::raw('count(quotation.id) as sales'),'quotation.created_at')->whereBetween("quotation.created_at",array($start, $end))->where('status',5)->groupBy('auto_company.id')->orderBy('sales','desc');

      return $comp;

   }
}

if(!function_exists('getAllOrders'))
{
   function getAllOrders($start=null, $end=null)
   {  
      if($start==null && $end==null)
      $orders = DB::table('quotation')->where('status',5)->orderBy('quotation.id','desc');
      else
      $orders = DB::table('quotation')->whereBetween("quotation.created_at",array($start, $end))->where('status',5)->orderBy('quotation.id','desc');

      return $orders;

   }
}


if(!function_exists('optionalProductSale'))
{
   function optionalProductSale($start=null, $end=null)
   {
      if($start==null && $end==null)
      $orders = DB::table('quotation')->where('status',5)->get();
      else
      $orders = DB::table('quotation')->whereBetween("quotation.created_at",array($start, $end))->where('status',5)->get();

      $services = array();
      $s = array();
      foreach ($orders as $key => $o) {
        $result = substr($o->service_opt, 1, -1);
        if($result!="")
          $services_array = explode(',', $result);
        else
          $services_array = array();

        $services[$key]['services'] = $services_array;
        foreach ($services_array as $cle => $serv_arr) {
          array_push($s, array("service_id"=>$serv_arr, "commande_id"=> $o->id));
          
        }
      }


      return $s;

   }
}

if(!function_exists('lastFiveCallMe'))
{
   function lastFiveCallMe($start=null, $end=null)
   {
    if($start==null && $end==null)
     $lastFiveCallMe = DB::table('callme_log')->orderBy('call_id','desc')->limit(5)->get();
   else
     $lastFiveCallMe = DB::table('callme_log')->whereBetween("callme_log.created_at",array($start, $end))->orderBy('call_id','desc')->limit(5)->get();

     return $lastFiveCallMe;

   }
}

if(!function_exists('getAllCallMeByCallReason'))
{
   // function getAllCallMeByCallReason($start=null, $end=null, $id_motif)
   // public function getAllCallMeByCallReason($optionalParam = null, $id_motif)
   function  getAllCallMeByCallReason($start, $end, $id_motif, $optionalParam = null)
   {
    if($start==null && $end==null)
     $allCallMe = DB::table('callme_log')->where('advisor_conclusion',$id_motif)->orderBy('call_id','desc');
    else
     $allCallMe = DB::table('callme_log')->whereBetween("callme_log.created_at",array($start, $end))->where('advisor_conclusion',$id_motif)->orderBy('call_id','desc');

     return $allCallMe;

   }
}

if(!function_exists('getAllProductContratContract'))
{
   // function getAllProductContratContract($start=null, $end=null,$product_type)
 function getAllProductContratContract( $start, $end, $product_type, $optionalParam = null)
   {
    if($start==null && $end==null)
     $AllContract = DB::table('quotation')->where([['quotation.status','=',5],['quotation.product_type','=',$product_type]])->orderBy('quotation.id','desc');
    else
     $AllContract = DB::table('quotation')->whereBetween("quotation.created_at",array($start, $end))->where([['quotation.status','=',5],['quotation.product_type','=',$product_type]])->orderBy('quotation.id','desc');

     return $AllContract;

   }
}


if(!function_exists('getAdvisorUsers'))
{
   function getAdvisorUsers($start=null, $end=null)
   {
    if($start==null && $end==null)
      $admins = App\Models\User::where([['usertype',"=",99], ['id',"<>",1]])->get();
    else
      $admins = App\Models\User::whereBetween("users.created_at",array($start, $end))->where([['usertype',"=",99], ['id',"<>",1]])->get();

      $advisors = array();
      foreach ($admins as $key => $admin) {
        if($admin->hasRole('advisor')){         
          $advisors[$key]['id_user'] = $admin->id;
          $advisors[$key]['firstname'] = $admin->firstname;
          $advisors[$key]['lastname'] = $admin->lastname;
          if($start==null && $end==null)
          $c = DB::table('callme_log')->where('advisor_user_id',$admin->id)->count();
          else
          $c = DB::table('callme_log')->whereBetween("callme_log.created_at",array($start, $end))->where('advisor_user_id',$admin->id)->count();

          $advisors[$key]['nbre'] = $c;
        }
      }

      return $advisors;

   }
}

if(!function_exists('getQuoteByAdvisorActor'))
{
   function getQuoteByAdvisorActor($start=null, $end=null)
   {
    if($start==null && $end==null)
      $quote_nb = DB::table('order_status_actor')
                    ->join('quotation','quotation.id','order_status_actor.order_id')
                    ->join('users','users.id','order_status_actor.actor_id')
                    ->select('actor_id','firstname','lastname','usertype', 'number_n', 'policy_number', 'order_id','order_status',DB::Raw('count(actor_id) as nb_dev'),'order_status_actor.created_at','order_status_actor.updated_at','quotation.created_at')
                    ->where([['order_status','=',0],['usertype','=',99],['actor_id','<>',1]])->groupBy('actor_id')->orderBy('nb_dev','desc')->get();
    else
      $quote_nb = DB::table('order_status_actor')
                    ->join('quotation','quotation.id','order_status_actor.order_id')
                    ->join('users','users.id','order_status_actor.actor_id')
                    ->select('actor_id','firstname','lastname','usertype', 'number_n', 'policy_number', 'order_id','order_status',DB::Raw('count(actor_id) as nb_dev'),'order_status_actor.created_at','order_status_actor.updated_at','quotation.created_at')
                    ->whereBetween("quotation.created_at",array($start, $end))
                    ->where([['order_status','=',0],['usertype','=',99],['actor_id','<>',1]])->groupBy('actor_id')->orderBy('nb_dev','desc')->get();

                    return $quote_nb;

   }
}

if(!function_exists('getOrderByAdvisorActor'))
{
   function getOrderByAdvisorActor($start=null, $end=null)
   {
    if($start==null && $end==null)
      $quote_nb = DB::table('order_status_actor')
                    ->join('quotation','quotation.id','order_status_actor.order_id')
                    ->join('users','users.id','order_status_actor.actor_id')
                    ->select('actor_id','firstname','lastname','usertype', 'number_n', 'policy_number', 'order_id','order_status',DB::Raw('count(actor_id) as nb_dev'),'order_status_actor.created_at','order_status_actor.updated_at','quotation.created_at')
                    ->where([['quotation.status','=',5],['order_status','=',0],['usertype','=',99],['actor_id','<>',1]])->groupBy('actor_id')->orderBy('nb_dev','desc')->get();
    else
      $quote_nb = DB::table('order_status_actor')
                    ->join('quotation','quotation.id','order_status_actor.order_id')
                    ->join('users','users.id','order_status_actor.actor_id')
                    ->select('actor_id','firstname','lastname','usertype', 'number_n', 'policy_number', 'order_id','order_status',DB::Raw('count(actor_id) as nb_dev'),'order_status_actor.created_at','order_status_actor.updated_at','quotation.created_at')
                    ->whereBetween("quotation.created_at",array($start, $end))
                    ->where([['quotation.status','=',5],['order_status','=',0],['usertype','=',99],['actor_id','<>',1]])->groupBy('actor_id')->orderBy('nb_dev','desc')->get();

                    return $quote_nb;

   }
}

if(!function_exists('getVASByAdvisorActor'))
{
   function getVASByAdvisorActor($start=null, $end=null)
   {
    if($start==null && $end==null){
      $quote_nb = DB::table('order_status_actor')
                    ->join('quotation','quotation.id','order_status_actor.order_id')
                    ->join('users','users.id','order_status_actor.actor_id')
                    ->select('actor_id','firstname','lastname','usertype', 'number_n', 'policy_number', 'order_id','order_status',DB::Raw('count(actor_id) as nb_dev'),'order_status_actor.created_at','order_status_actor.updated_at','quotation.created_at')
                    ->where([['quotation.status','=',5],['quotation.service_opt','<>',"[]"],['order_status','=',0],['usertype','=',99],['actor_id','<>',1]])->groupBy('actor_id')->orderBy('nb_dev','desc')->get();
    }  
    else{
      $quote_nb = DB::table('order_status_actor')
                    ->join('quotation','quotation.id','order_status_actor.order_id')
                    ->join('users','users.id','order_status_actor.actor_id')
                    ->select('actor_id','firstname','lastname','usertype', 'number_n', 'policy_number', 'order_id','order_status',DB::Raw('count(actor_id) as nb_dev'),'order_status_actor.created_at','order_status_actor.updated_at','quotation.created_at')
                    ->whereBetween("quotation.created_at",array($start, $end))
                    ->where([['quotation.status','=',5],['quotation.service_opt','<>',"[]"],['order_status','=',0],['usertype','=',99],['actor_id','<>',1]])->groupBy('actor_id')->orderBy('nb_dev','desc')->get();
    }
      return $quote_nb;
    }
}



if(!function_exists('getAllQuotation'))
{
   function getAllQuotation($start=null, $end=null)
   {
      if($start==null && $end==null)
      $orders = DB::table('quotation')->where('status','<=',5);
      else
      $orders = DB::table('quotation')->whereBetween("quotation.created_at",array($start, $end))->where('status','<=',5);

      return $orders;

   }
}

if(!function_exists('lastFiveOrders'))
{
   function lastFiveOrders($start=null, $end=null)
   {
      if($start==null && $end==null)
     $lastFiveOrders = DB::table('quotation')
                          ->join('users','users.id','quotation.user_id')
                          ->select('quotation.id as qid','quotation.number_n','quotation.status','quotation.user_id','quotation.product_type','quotation.created_at')
                          ->where('quotation.status','>=',1)->orderBy('quotation.id','desc')->limit(5)->get();
      else
        $lastFiveOrders = DB::table('quotation')
                          ->join('users','users.id','quotation.user_id')
                          ->select('quotation.id as qid','quotation.number_n','quotation.status','quotation.user_id','quotation.product_type','quotation.created_at')
                          ->whereBetween("quotation.created_at",array($start, $end))->orderBy('quotation.id','desc')
                          ->where('quotation.status','>=',1)->limit(5)->get();

     return $lastFiveOrders;

   }
}


if(!function_exists('deliveryZone'))
{
   function deliveryZone($start=null, $end=null)
   {
      if($start==null && $end==null)
     $delivery_zone = DB::table('delivery_tour_route')
                          ->join('commune','commune.id','delivery_tour_route.commune_id')
                          ->select('ville','commune','commune_id',DB::raw('count(delivery_tour_route.id) as nb'))
                          ->groupBy('commune_id')
                          ->get();
      else
        $delivery_zone = DB::table('delivery_tour_route')
                          ->join('commune','commune.id','delivery_tour_route.commune_id')
                          ->select('ville','commune','commune_id',DB::raw('count(delivery_tour_route.id) as nb','delivery_tour_route.created_at'))
                          ->groupBy('commune_id')
                          ->whereBetween("delivery_tour_route.created_at",array($start, $end))->get();

     return $delivery_zone;

   }
}

if(!function_exists('deliveryManStats'))
{
   function deliveryManStats($start=null, $end=null)
   {
      if($start==null && $end==null)
     $delivery_man = DB::table('delivery_tour')
                          ->join('users','users.id','delivery_tour.deliveryman_id')
                          ->select('firstname','lastname','deliveryman_id',DB::raw('count(delivery_tour.deliveryman_id) as nb'))
                          ->groupBy('deliveryman_id')
                          ->get();
      else
        $delivery_man = DB::table('delivery_tour')
                          ->join('users','users.id','delivery_tour.deliveryman_id')
                          ->select('firstname','lastname','deliveryman_id',DB::raw('count(delivery_tour.deliveryman_id) as nb'))
                          ->groupBy('deliveryman_id')
                          ->whereBetween("delivery_tour.created_at",array($start, $end))->get();

     return $delivery_man;

   }
}



if (!function_exists('getAllOrders')) {
    function getAllOrders($start = null, $end = null)
    {
        // Construction de la requête
        $query = DB::table('quotation')->where('status', 5);

        // Si des dates de début et de fin sont fournies
        if ($start !== null && $end !== null) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        // Ordre par ID décroissant
        $query->orderBy('id', 'desc');

        // Exécuter la requête et retourner les résultats
        return $query->get();
    }
}



if(!function_exists('optionalProductSale'))
{
   function optionalProductSale($start=null, $end=null)
   {
      if($start==null && $end==null)
      $orders = DB::table('quotation')->where('status',5)->get();
      else
      $orders = DB::table('quotation')->whereBetween("quotation.created_at",array($start, $end))->where('status',5)->get();

      $services = array();
      $s = array();
      foreach ($orders as $key => $o) {
        $result = substr($o->service_opt, 1, -1);
        if($result!="")
          $services_array = explode(',', $result);
        else
          $services_array = array();

        $services[$key]['services'] = $services_array;
        foreach ($services_array as $cle => $serv_arr) {
          array_push($s, array("service_id"=>$serv_arr, "commande_id"=> $o->id));
          
        }
      }


      return $s;

   }
}



if(!function_exists('getAllQuotation'))
{
   function getAllQuotation($start=null, $end=null)
   {
      if($start==null && $end==null)
      $orders = DB::table('quotation')->where('status','<=',5);
      else
      $orders = DB::table('quotation')->whereBetween("quotation.created_at",array($start, $end))->where('status','<=',5);

      return $orders;

   }
}

if(!function_exists('lastFiveOrders'))
{
   function lastFiveOrders($start=null, $end=null)
   {
      if($start==null && $end==null)
     $lastFiveOrders = DB::table('quotation')
                          ->join('users','users.id','quotation.user_id')
                          ->select('quotation.id as qid','quotation.number_n','quotation.status','quotation.user_id','quotation.product_type','quotation.created_at')
                          ->where('quotation.status','>=',1)->orderBy('quotation.id','desc')->limit(5)->get();
      else
        $lastFiveOrders = DB::table('quotation')
                          ->join('users','users.id','quotation.user_id')
                          ->select('quotation.id as qid','quotation.number_n','quotation.status','quotation.user_id','quotation.product_type','quotation.created_at')
                          ->whereBetween("quotation.created_at",array($start, $end))->orderBy('quotation.id','desc')
                          ->where('quotation.status','>=',1)->limit(5)->get();

     return $lastFiveOrders;

   }
}



// 


