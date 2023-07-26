<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cook extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
