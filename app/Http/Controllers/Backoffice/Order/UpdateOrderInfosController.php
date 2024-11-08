<?php

namespace App\Http\Controllers\Backoffice\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Backoffice\AutoInfos;
use App\Models\Backoffice\Quotation;
use App\Models\Backoffice\assuranceAutoInfos;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Log; 
class UpdateOrderInfosController extends Controller
{

  public function updateClient(Request $request)
  {
      // Récupération des données depuis la requête
      $id = $request->get('uid');
      $firstname = $request->get('first_name');
      $lastname = $request->get('last_name');
      $contact = $request->get('contact');
      $email = ($request->get('email') == "") ? time() . "@email.com" : $request->get('email');
  
      // Log des informations reçues
      Log::info('Données client reçues:', [
          'id' => $id,
          'firstname' => $firstname,
          'lastname' => $lastname,
          'contact' => $contact,
          'email' => $email,
          'job_id' => $request->get('job_id'),
          'date_pc' => $request->get('date_pc')
      ]);
  
      // Initialisation de la variable de réponse
      $response = 0;
  
      // Mise à jour des informations du client
      if ($request->get('job_id') && $request->get('date_pc')) {
          $job_id = $request->get('job_id');
          $date_pc = Carbon::createFromFormat("d/m/Y", $request->get('date_pc'))->toDateString();
  
          // Log de la date formatée
          Log::info('Date formatée pour date_pc:', ['date_pc' => $date_pc]);
  
          // Effectuer la mise à jour et log du résultat
          $response = User::where('id', $id)
              ->update([
                  'firstname' => $firstname,
                  'lastname' => $lastname,
                  'contact' => $contact,
                  'email' => $email,
                  'job_id' => $job_id,
                  'date_pc' => $date_pc
              ]);
      } else {
          // Mise à jour sans job_id et date_pc
          $response = User::where('id', $id)
              ->update([
                  'firstname' => $firstname,
                  'lastname' => $lastname,
                  'contact' => $contact,
                  'email' => $email
              ]);
      }
  
      // Log de la valeur de retour de la mise à jour
      Log::info('Nombre de lignes affectées par la mise à jour:', ['response' => $response]);
  
      // Mise à jour de la table "quotation"
      DB::table("quotation")->where("id", $request->get('qid'))->update(["collect_data" => null]);
  
      // Vérification du résultat et redirection
      if ($response > 0) {
          // return redirect()->route('client.afficher')->with('success', 'Les informations du client ont été mises à jour avec succès.');
          return redirect()->back()->with('success', 'Les informations du client ont été mises à jour avec succès.');
      } else {
          // return redirect()->route('client.afficher')->with('error', 'Aucune modification n\'a été apportée aux informations du client.');
          return redirect()->back()->with('error', 'Aucune modification n\'a été apportée aux informations du client.');
      }
  }
  
  
    // public function updateVehicule(Request $request)
    // {
    //     // Validation des données reçues
    //     $validated = $request->validate([
    //         'Immatriculation' => 'required|string|max:255',
    //         'marque' => 'required|integer',
    //         'firstrelease' => 'required|date',
    //         'puissance_fiscale' => 'required|integer',
    //         'energie' => 'required|string',
    //         'genre' => 'required|integer',
    //         'category' => 'required|integer',
    //         'cu' => 'nullable|integer',
    //         'cylindree' => 'required|integer',
    //         'place' => 'required|integer|min:1',
    //         'valeur_neuve' => 'nullable|numeric',
    //         'valeur_venale' => 'required|numeric',
    //         'zone' => 'required|integer',
    //         'color' => 'required|integer',
    //         // Ajoutez d'autres règles de validation si nécessaire
    //     ]);
        
    
    //     // Recherche et mise à jour du véhicule
    //     $vehicule = AutoInfos::findOrFail($validatedData['aid']);
    
    //     $vehicule->update([
    //         'matriculation' => $validatedData['Immatriculation'],
    //         'make_id' => $validatedData['marque'],
    //         'power' => $validatedData['puissance_fiscale'],
    //         'energy' => $validatedData['energie'],
    //         'category' => $validatedData['category'],
    //         'type_id' => $validatedData['genre'],
    //         'charge_utile' => $validatedData['cu'],
    //         'cylindree' => $validatedData['cylindree'] ?? null, // Gérer le champ nullable
    //         'firstrelease' => Carbon::createFromFormat('d/m/Y', $validatedData['firstrelease'])->toDateString(),
    //         'placesnumber' => $validatedData['place'],
    //         'parkingzone' => $validatedData['zone'],
    //         'vneuve' => $validatedData['valeur_neuve'],
    //         'vvenale' => $validatedData['valeur_venale'],
    //         'updated_at' => now(),
    //     ]);
    
    //     // Réinitialiser les données de collecte dans la table 'quotation'
    //     DB::table('quotation')->where('id', $validatedData['qid'])->update(['collect_data' => null]);
    
    //     return response()->json(['success' => true, 'message' => 'Véhicule mis à jour avec succès']);
    // }

    public function updateVehicule(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'Immatriculation' => 'nullable|string|max:255',
            'marque' => 'nullable|exists:make,id',
            'puissance_fiscale' => 'nullable|integer|min:1|max:13',
            'energie' => 'nullable|string|in:E,D',
            'category' => 'nullable|exists:auto_categories,id',
            'genre' => 'nullable|exists:car_type,id_type',
            'cu' => 'nullable|integer|min:1|max:16',
            'cylindree' => 'nullable|integer|min:1|max:5',
            'firstrelease' => 'nullable|date_format:d/m/Y',
            'place' => 'nullable|integer|min:1',
            'zone' => 'nullable|exists:commune,id',
            'valeur_neuve' => 'nullable|numeric|min:0',
            'valeur_venale' => 'nullable|numeric|min:0'
        ]);
    
        // Récupérer l'identifiant du véhicule
        $id = $request->get('aid');
        Log::debug('ID du véhicule à mettre à jour : ', [$id]);
    
        // Vérifiez si l'ID est vide
        if (empty($id)) {
            return response()->json(['success' => false, 'message' => 'ID du véhicule manquant.']);
        }
    
        // Récupérer le véhicule à mettre à jour
        $vehicle = autoInfos::find($id);
    
        // Vérifiez si le véhicule existe
        if (!$vehicle) {
            Log::debug('Véhicule non trouvé avec l\'ID : ', [$id]);
            return response()->json(['success' => false, 'message' => 'Véhicule non trouvé.']);
        }
    
        // Préparez les données à mettre à jour
        $dataToUpdate = $request->only([
            'Immatriculation', 
            'marque', 
            'puissance_fiscale', 
            'energie', 
            'category', 
            'genre', 
            'cu', 
            'cylindree', 
            'firstrelease', 
            'place', 
            'zone', 
            'valeur_neuve', 
            'valeur_venale'
        ]);
    
        try {
            // Mettre à jour les informations du véhicule
            $response = $vehicle->update(array_filter($dataToUpdate)); // Utilisez array_filter pour ignorer les champs null
    
            // Mettre à jour la table de quotation
            if ($request->has('qid')) {
                DB::table("quotation")->where("id", $request->get('qid'))->update(["collect_data" => null]);
            }
    
            // Vérifier si la mise à jour a réussi
            if ($response) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Aucune mise à jour effectuée.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    
    public function updateGarantie(Request $request)
    {
      $type = $request->get('formule_type');
      $id = $request->get('assurance_auto_info_id');
      $my_guaranties = $request->get('garantie');
      $formule = $request->get('formule');
      $guarante= $this->format_garantie($type,$my_guaranties,$formule);
      $releasedate = Carbon::createFromFormat("d/m/Y", $request->get('releasedate'))->toDateString();
      $periode = $request->get('periode');
      $response = assuranceAutoInfos::where('id', $id)
          ->update([
            'guarante' => $guarante,
            'releasedate' => $releasedate,
            'periode' => $periode,
            'subscription_type' => $type
          ]);
        DB::table("quotation")->where("id",$request->get('qid'))->update(["collect_data"=>null]);
      if($response)
      {
        echo 1;
      }
      else
      {
        echo 2;
      }
    }


    public function updateService(Request $request)
    {

      $qid = $request->get('qid');
      $service = $request->get('service');
      $service= $this->format_service($service);

      $response = quotation::where('id', $qid)
          ->update([
            'service_opt'=>$service
            ]);  
      DB::table("quotation")->where("id",$request->get('qid'))->update(["collect_data"=>null]);
      return redirect()->back();  
    }


    // public function updateReduction(Request $request)
    // {
    //     dd($request->all()); // Pour voir toutes les données envoyées
    // }

    public function priorityOrder($qid)
    {
      $response = quotation::where('id', $qid)->update(['priority'=>1]); 

      return $response;
    }
    


}
