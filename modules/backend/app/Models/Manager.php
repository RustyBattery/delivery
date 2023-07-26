<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends BaseModel
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
}
