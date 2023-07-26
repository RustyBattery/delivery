<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'pgsql_auth';

    protected $fillable = [
        'name',
        'email',
        'password',
        'birthdate',
        'gender',
        'phone',
        'roles',
        'is_banned',
    ];

    protected $hidden = [
        'password',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();;
    }

    public function bans()
    {
        return $this->hasMany(Ban::class);
    }

    public function ban_sync(){
        if($this->is_banned){
            $bans = $this->bans()->whereDate('end_time', '>', Carbon::now())->count();
            if(!$bans){
                $this->is_banned = false;
                $this->save();
            }
        }
    }

    public function is_admin(){
        if($this->roles()->where('slug', 'admin')->count()){
            return true;
        }
        return false;
    }
}
