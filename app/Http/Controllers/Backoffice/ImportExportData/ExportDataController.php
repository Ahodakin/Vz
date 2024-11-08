<?php

namespace App\Http\Controllers\Backoffice\ImportExportData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ExportDataController extends Controller
{
    public function showExportPage()
	{
    	return view("Backoffice.backend.import-export.export")->with(['isActive'=>'config']);
	}

	public function postExportClient(Request $req)
	{
		$field_query = implode(",", $req->field_query);

		$clients = DB::select("select $field_query from quotation, users where users.id=quotation.user_id and quotation.status=5 and quotation.created_at between '$req->start 00:00:00' and '$req->end 00:00:00'");
		$data = array();
		foreach ($clients as $result) {
		   $data[] = (array) $result;
		}
		//dd($data);
		
		Excel::create('Client_'.$req->start.'_'.$req->start, function($excel) use($data) {
		    $excel->sheet('Clients', function($sheet) use($data) {
		        $sheet->fromArray($data);
		    });
		})->export('xls');

		return redirect()->back();
		
		/*$client = DB::table('quotation')->join('users','users.id','quotation.user_id')
				->select($field_query.",quotation.created_at")
				->where("quotation.status",5)
				->whereBetween("quotation.created_at",array($req->start, $req->end))->get();*/
	}
}
