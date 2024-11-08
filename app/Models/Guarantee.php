<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    protected $table = 'auto_guarantee';

    protected $fillable = [
        'codeguar', 'titleguar', 'desciption',
    ];

    public $timestamps = false;
}
