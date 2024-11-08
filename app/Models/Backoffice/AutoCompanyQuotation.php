<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoCompanyQuotation extends Model
{
    use HasFactory;
    
    protected $table = 'auto_companyquotation';
   


       // Relation avec AutoGuarantee
       public function autoGuarantee()
       {
           return $this->belongsTo(AutoGuarantee::class, 'guaranteeid', 'id');
       }
}
