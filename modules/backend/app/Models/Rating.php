<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "dish_id",
        "customer_id",
        "value",
        "text"
    ];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
