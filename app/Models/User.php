<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Backoffice\Quotation;
use App\Models\Backoffice\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'firstname',
        'lastname',
        'gender',
        'dob',
        'contact',
        'email',
        'password',
        'avatar',
        'status',
        'usertype',
    ];

    public function log()
    {
        return $this->hasMany('App\Models\Log');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'user_id');
    }
  
    public function deliveryTours()
    {
        return $this->hasMany(DeliveryTour::class, 'deliveryman_id');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public static function check_mail($email)
    {
        return self::where('email', $email)->first();
    }
    
    /**
     * Vérifie si l'utilisateur est un utilisateur "auto".
     * @return bool
     */

    public static function check_auto_user($user_id)
    {
        $user = self::find($user_id);

        // vérifiez si l'utilisateur a un certain rôle ou attribut.
        if ($user && $user->usertype === 'auto') {
            return true;
        }

        return false;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
