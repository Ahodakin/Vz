<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class OrderStatusActor extends Model
{
    use HasFactory;

    protected $table = 'order_status_actor';

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
