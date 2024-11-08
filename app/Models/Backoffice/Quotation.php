<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\user;
use App\Models\Make;
use App\Models\Backoffice\AssuranceAutoInfos;

class Quotation extends Model
{
    use HasFactory;
    
    
    protected $table = 'quotation'; 

    public $timestamps = true;
    protected $fillable = ['view'];


    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function assuranceAutoInfo()
    {
        return $this->belongsTo(AssuranceAutoInfos::class, 'assurance_infos_id');
    }


    
    public function autoInfo()
    {
        return $this->belongsTo(AutoInfos::class, 'product_id');
    }


    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }


    public function carType()
    {
        return $this->belongsTo(CarType::class, 'type_id');
    }


    public function make()
    {
        return $this->belongsTo(Make::class, 'make_id'); 
    }

    
    public function autoCategory()
    {
        return $this->belongsTo(AutoCategories::class, 'category_id'); 
    }


    public function assuranceVoyageInfo()
    {
        return $this->belongsTo(AssuranceVoyageInfos::class, 'assurance_infos_id');
    }


    public function deliveryTourOrder()
    {
        return $this->hasOne(DeliveryTourOrder::class, 'order_id');
    }

    public function orderStatusActors()
    {
        return $this->hasMany(OrderStatusActor::class, 'order_id'); // Remplacez 'order_id' par le nom de la clé étrangère
    }
    
    public function deliveryTour()
    {
        return $this->belongsTo(DeliveryTour::class, 'delivery_tour_id');
    }
    
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
