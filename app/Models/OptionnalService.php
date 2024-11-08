<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class OptionnalService extends Model
{
    protected $table = "optional_service";

    public static function SelectedServiceAmount($services)
    {
        $som_serv = 0;
        if(isset($services) && is_array($services) && sizeof($services) != 0) {
            foreach ($services as $s) {
                $serv = self::where('id', $s)->first();
                $som_serv += $serv->amount;
            }
        }
        return $som_serv;
    }
}
