<?php

namespace App\Http\Controllers\Backoffice\CRUD\Guarantee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backoffice\Guarantee;
class GuaranteeController extends Controller
{
    public function showPage()
    {
    	$guarantees = Guarantee::where('isdeprecated',0)->get();
    	return view('Backoffice.backend.config.guarantee', compact('guarantees'));
    }

    public function getGuarantee($id_guard)
    {
    	$guarantees = Guarantee::where(['isdeprecated'=>0,'id'=>$id_guard])->first();	
    	if($guarantees) return json_encode($guarantees); else echo 0;
    }

	 // Méthode pour mettre à jour une garantie
	 public function editGuarantee(Request $request)
	 {
		 // Validation des données
		 $request->validate([
			 'codeguar' => 'required|string|max:255',
			 'guarantee' => 'required|string|max:255',
			 'description' => 'nullable|string',
		 ]);
 
		 // Trouver la garantie par ID
		 $guarantee = Guarantee::find($request->idguar);
 
		 // Mettre à jour les champs
		 $guarantee->codeguar = $request->codeguar;
		 $guarantee->titleguar = $request->guarantee;
		 $guarantee->description = $request->description;
 
		 // Sauvegarder les modifications
		 $guarantee->save();
 
		 return redirect()->back()->with('success', 'Garantie mise à jour avec succès !');
	 }
}
