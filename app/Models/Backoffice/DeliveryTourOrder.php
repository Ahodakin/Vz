<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTourOrder extends Model
{
    use HasFactory;

    protected $table = 'delivery_tour_order';

    // Relation to Quotation
    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'order_id');
    }
}
