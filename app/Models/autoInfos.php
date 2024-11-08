<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class autoInfos extends Model
{
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
        return $this->belongsTo(City::class, 'city_id');
    }

  public $timestamps = false;
}
