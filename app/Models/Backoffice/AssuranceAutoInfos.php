<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Periode;
class AssuranceAutoInfos extends Model
{
    use HasFactory;

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
