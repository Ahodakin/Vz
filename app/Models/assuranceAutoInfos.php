<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class assuranceAutoInfos extends Model
{
      protected $table = 'assurance_auto_infos';
      public $timestamps = false;
      public function periode()
      {
          return $this->belongsTo(Periode::class, 'periode_id');
      }
  
      public function quotation()
      {
          return $this->hasOne(Quotation::class, 'assurance_infos_id');
      }
}
