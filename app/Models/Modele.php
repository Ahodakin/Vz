<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
     protected $table = 'model';

     public function make()
     {
         return $this->belongsTo(Make::class, 'make_id');
     }
}
