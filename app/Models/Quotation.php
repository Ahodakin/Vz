<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Quotation extends Model
{
    protected $table = 'quotation';

    public static function get_unique_number()
    {
        // Requête pour obtenir la dernière entrée du jour
        $today_quote_last = static::whereDate('created_at', DB::raw('CURDATE()'))->orderBy('id', 'desc')->first();

        // Vérifiez si $today_quote_last existe
        if ($today_quote_last) {
            // Si un enregistrement est trouvé, extrayez le numéro unique et ajoutez 1
            $today_quote_nb = intval(substr($today_quote_last->number_n, 13)) + 1;
        } else {
            // Si aucun enregistrement n'est trouvé, démarrez à 1
            $today_quote_nb = 1;
        }

        // Générer le suffixe, la date et le numéro unique
        $chiffre = str_pad($today_quote_nb, 4, '0', STR_PAD_LEFT);
        $_SUFFIX = "ARO";
        $today = date("dmY");
        $number = $_SUFFIX . "/" . $today . "/" . $chiffre;

        // Vérifier si ce numéro est déjà utilisé
        $nb = static::where('number_n', $number)->count();

        // Si le numéro existe déjà, refaire l'appel récursivement
        if ($nb > 0) {
            return static::get_unique_number();
        }

        // Retourner le numéro unique en majuscules
        return strtoupper($number);
    }
}
