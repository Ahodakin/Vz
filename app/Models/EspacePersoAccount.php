<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class EspacePersoAccount extends Authenticatable 
{
    use Notifiable;

    protected $table = 'espace_perso_account';

    protected $fillable = ['name','phone_number','email',  'password', 'avatar','status'];

    protected $hidden = ['password',  'remember_token'];

}