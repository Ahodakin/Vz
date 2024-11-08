<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Log extends Model
{
    use HasFactory;

    protected $table = 'log';
    public $timestamps = false;

    public static function writeInDB($action, $desc="")
    {
        // Récupérer l'utilisateur authentifié
        $userId = Auth::id(); 

        // Enregistrement du log dans la base de données
        // DB::table('log')->insert([
        //     'user_id' => $userId,
        //     'log_description' => $action,
        //     'created_at' => Carbon::now(), // Date et heure actuelles
        // ]);
    }
}
