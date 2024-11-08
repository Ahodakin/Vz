<?php

namespace App\Http\Controllers\Backoffice\CRUD\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backoffice\autoCompany;
use App\Models\Backoffice\autoGuarantee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class CompanyController extends Controller
{
    public function showPage()
    {
        $compagnies = autoCompany::where('enabled','!=',-1)->get();
    	$guaranties = autoGuarantee::where('isdeprecated',0)->get();
        //dd($guaranties);
    	return view('Backoffice.backend.config.company')->with(['compagnies' => $compagnies,'guaranties' => $guaranties, 'isActive'=>'config']);
    }

    public function showTarifPage($id_comp)
    {
        $tarifs = DB::table('auto_companyquotation')
            ->join('auto_guarantee', 'auto_guarantee.id', '=', 'auto_companyquotation.type_assurance')
            ->orderBy('auto_guarantee.id', 'asc')
            ->where('auto_companyquotation.companyid', $id_comp)
            ->get();
    
        $compagnie = autoCompany::where('id', $id_comp)->first();
    
        return view('Backoffice.backend.config.tarifsautocompany')
            ->with(['compagnie' => $compagnie, 'tarifs' => $tarifs, 'isActive' => 'config']);
    }
    

    public function editCompany(Request $req)
    {

        $company = autoCompany::find($req['idcomp']);
        if ($company) {
            $company->update([
                'categorie' => $req['compname'],
                'shortdesc' => $req['description'],
                'enabled' => $enabled
            ]);
            Session::flash('success', 'La catégorie a bien été mise à jour');
        } else {
            Session::flash('error', 'Compagnie non trouvée');
        }
        return redirect()->route('categoryPage');        
    }

    public function deleteCompany($id_comp)
    {
       $del = autoCompany::where('id', $id_comp)->update([
            'enabled' => -1
        ]);
    }
    
}
