<?php

namespace App\Models;

use App\Events\CreateRefreshToken;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'birthdate',
        'gender',
        'phone',
        'password',
        'refresh_token',
        'is_banned',
    ];

    protected $hidden = [
        'password',
        'refresh_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        $roles = $this->roles;
        $user_roles = array();
        foreach ($roles as $role) {
            array_push($user_roles, $role->slug);
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $user_roles,
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();;
    }

    public function active_ban()
    {
        return Ban::query()->where('user_id', $this->id)
            ->where(function ($query) {
                $query->whereDate('end_time', '>=', Carbon::now())
                    ->orWhere('end_time', null);
            })->first();
    }

    public function issue_refresh_token()
    {
        $this->refresh_token = bin2hex(random_bytes(64));
        $this->save();
        CreateRefreshToken::dispatch($this->refresh_token);
        return $this->refresh_token;
    }

    public function revoke_refresh_token()
    {
        $this->refresh_token = null;
        $this->save();
    }
}
