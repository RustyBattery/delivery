<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "menu_id",
        "photo",
        "category_id",
        "is_vegetarian",
        "price",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function restaurant()
    {
        return $this->menu->restaurant;
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function rating()
    {
        $rating = round($this->ratings()->avg('value'), 2);
        if(!$rating){
            $rating = null;
        }
        return  $rating;
    }
}
