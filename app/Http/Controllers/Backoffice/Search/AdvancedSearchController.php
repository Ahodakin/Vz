<?php

namespace App\Http\Controllers\Backoffice\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class AdvancedSearchController extends Controller
{
    public function showdeleteTracePage()
    {
      return view('Backoffice.backend.order.delete-trace-devis')->with(['isActive'=>'settingsmanager']);
    }

    public function deleteInfoDevisPost(Request $req)
    {
      $q = DB::table("quotation")->where('number_n',$req->num_devis);

      if($q->count()>0){
        DB::table("order_status_actor")->where("order_id",$q->first()->id)->delete();
        DB::table("delivery_tour_order")->where("order_id",$q->first()->id)->delete();
        DB::table("quotation")->where("id",$q->first()->id)->delete();
        Session::flash('success','Dévis <<'.$req->num_devis.'>> supprimé avec succès');
      }
      else{
        Session::flash('error','Aucun dévis n\'a été trouvé');
      }
        return redirect()->back();

    }
}
