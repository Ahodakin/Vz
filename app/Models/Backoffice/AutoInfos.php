<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Make;
use App\Models\Backoffice\AssuranceAutoInfos;
class AutoInfos extends Model
{
    use HasFactory;
    protected $table = 'auto_infos';

    public function make()
    {
        return $this->belongsTo(Make::class, 'make_id');
    }

    public function autoCategory()
    {
        return $this->belongsTo(AutoCategories::class, 'category_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'parkingzone');
    }

    public function assuranceAutoInfo()
    {
        return $this->belongsTo(AssuranceAutoInfos::class, 'assurance_infos_id'); 
    }
}
