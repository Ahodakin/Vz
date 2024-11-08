<?php

namespace App\Models\Backoffice;

use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRole implements RoleContract
{
    use HasFactory;

    protected $fillable = ['name', 'display_name', 'description'];
}

