<?php
namespace App\Http\Controllers\Backoffice\CRUD\Reglementary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReglementaryCoast;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class OtherController extends Controller
{
    public function showConfigPage()
    {
        $conf = ReglementaryCoast::first();
        return view("Backoffice.backend.config.config-other-coast", ["config" => $conf, 'isActive' => 'config']);
    }

    public function editAutoOtherRate(Request $request)
    {
        // Définir les règles de validation
        $rules = array(
            'autotaux' => 'required|numeric',
            'fga'  => 'required|numeric',
            'default_redcom'  => 'required|numeric',
        );

        // Messages personnalisés pour la validation
        $messages = [
            'autotaux.required' => 'Le taux automobile est obligatoire',
            'fga.required'  => 'Le fond de garantie obligatoire est requis',
            'default_redcom.required'  => 'Le taux de remise par défaut est requis',
            'autotaux.numeric' => 'Ce champ doit être numérique',
            'fga.numeric'  => 'Ce champ doit être numérique',
            'default_redcom.numeric'  => 'Ce champ doit être numérique',
        ];

        // Validation des données
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validation échoue
        if ($validator->fails()) {
            Session::flash('error', 'Oups!! Une erreur s\'est produite');
            return Redirect::back()
                ->withErrors($validator);
        } else {
            // Activer ou désactiver la remise maximale
            $active_max_discount = ($request->has('enabled_max_discount') && $request->enabled_max_discount == 'on') ? 1 : 0;

            // Mise à jour des tarifs dans la base de données
            ReglementaryCoast::where('id', 1)->update([
                'autotaux' => $request->get('autotaux'),
                'fga' => $request->get('fga'),
                'default_redcom' => $request->get('default_redcom'),
                'active_max_discount' => $active_max_discount
            ]);

            // Message de succès
            Session::flash('success', 'Tarifs mis à jour avec succès!');
            return Redirect::back();
        }
    }
}

