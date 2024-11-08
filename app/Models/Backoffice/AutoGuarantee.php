<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoGuarantee extends Model
{
    use HasFactory;

    protected $table = 'auto_guarantee';

    public function autoCompanyQuotations()
    {
        return $this->hasMany(AutoCompanyQuotation::class, 'guaranteeid');
    }
}
