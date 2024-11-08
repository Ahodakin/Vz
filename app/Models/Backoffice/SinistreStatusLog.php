<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SinistreStatusLog extends Model
{
    use HasFactory;
    protected $table = 'sinistre_status_logs';
    protected $primaryKey = 'id_log';
    public $timestamps = true;
    
    public function sinistre()
    {
        return $this->belongsTo(Sinistre::class, 'sinistre_id', 'sin_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
