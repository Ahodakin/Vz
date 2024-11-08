<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backoffice\Pays;
class AssuranceVoyageInfos extends Model
{
    use HasFactory;
    protected $table = 'assurance_voyage_infos';

    public function pays()
    {
        return $this->belongsTo(Pays::class, 'pays_id', 'id');
    }
}
