<?php

namespace App\Models\Backoffice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    use HasFactory;
    protected $table = 'auto_guarantee';

    protected $fillable = [
        'codeguar', 'titleguar', 'desciption', 'isdeprecated', 'type_assurance'
    ];
}
