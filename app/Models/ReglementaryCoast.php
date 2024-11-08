<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReglementaryCoast extends Model
{
    protected $table = 'auto_reglementarycost';

    public static function getAmountRC($category, $zone, $energy="E", $power=1,$cu=1,$genre=1,$cyl=1)
    {
        if(static::first()->enable_circulaire==1) $zone=1;

        $rcivile = json_decode(self::first()->rcivile, true);
        $zone = DB::table('city')->where("id",$zone)->first()->zone;
        if($rcivile){
            if($category==1){
                return $rcivile['rcivile']['categorie']['cat'.$category]['zone'.$zone][$energy][$power];
            }
            elseif($category==2){
                return $rcivile['rcivile']['categorie']['cat'.$category]['zone'.$zone][$cu];
            }
            elseif($category==3){
                return $rcivile['rcivile']['categorie']['cat'.$category]['zone'.$zone][$cu];
            }
            elseif($category==5){
                return $rcivile['rcivile']['categorie']['cat'.$category]['zone'.$zone][$cyl];
            }
            elseif($category==8){
                if($genre<=2)
                    return $rcivile['rcivile']['categorie']['cat'.$category][$genre]['zone'.$zone][$energy][$power];
                else
                    return $rcivile['rcivile']['categorie']['cat'.$category][$genre]['zone'.$zone][$cu];
            }
            elseif($category==12){
                return $rcivile['rcivile']['categorie']['cat'.$category]['zone'.$zone][$energy][$power];
            }
            else
                return null;
        }
        else{
            return null;
        }
    }

    public static function getAmountRA($periode)
    {
        $ranticipe = json_decode(self::first()->ranticipe, true);
        if($periode==1) return $ranticipe['norm'];else return $ranticipe['execpt'] ;    }

    public static function getAmountDR($selectedformule)
    {
        $drecours = json_decode(self::first()->drecours, true);

       if($selectedformule=='tsimple' || $selectedformule=='tcomplet') return $drecours['norm'];else return $drecours['execpt'] ;
    }

    public static function getFraisGestionAroli()
    {
        return self::first()->fraisaroli;
    }
}
