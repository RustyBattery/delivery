<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRole;

    protected $fillable = [
        'id',
        'name',
        'email',
        'customer_id',
        'roles',
    ];

    public function attach_customer()
    {
        $customer = Customer::create(["user_id" => $this->id]);
        $this->roles = ["customer" => ["id" => $customer->id]];
    }

    public function customer()
    {
        return Customer::query()->where('user_id', $this->id)->first();
    }

    public function cook()
    {
        return Cook::query()->where('user_id', $this->id)->first();
    }

    public function manager()
    {
        return Manager::query()->where('user_id', $this->id)->first();
    }

    public function courier()
    {
        return Courier::query()->where('user_id', $this->id)->first();
    }
}
