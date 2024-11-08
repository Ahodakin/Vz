<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Sinistre extends Model
{
    use HasFactory;
    protected $table = 'sinistre';

    public function sinManager()
    {
        return $this->belongsTo(User::class, 'sin_manager');
    }

    protected $primaryKey = 'sin_id';  // Clé primaire personnalisée


    public function statusLogs()
    {
        return $this->hasMany(SinistreStatusLog::class, 'sinistre_id', 'sin_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
