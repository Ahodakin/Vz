<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoCategories extends Model
{
    use HasFactory;
    protected $table = 'auto_categories';
    public $timestamps = false;

    public function autos()
    {
        return $this->hasMany(AutoInfos::class, 'category_id'); 
    }
}
