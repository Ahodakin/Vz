<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
   protected $table = 'make';

   public function autoInfos()
   {
       return $this->hasMany(AutoInfos::class, 'make_id');
   }

    public function models()
    {
        return $this->hasMany('App\Models\Modele');
    }
    
}
