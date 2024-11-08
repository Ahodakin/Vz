<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class DeliveryTour extends Model
{
    use HasFactory;

    protected $table = 'delivery_tour';

    public function deliveryman()
    {
        return $this->belongsTo(User::class, 'deliveryman_id');
    }

    public function prospects()
    {
        return $this->hasMany(Quotation::class, 'product_id');
    }
}
