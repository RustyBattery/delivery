<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function dishes()
    {
        return $this->hasManyThrough(Dish::class, Menu::class);
    }

    public function rating()
    {
        $ratings = [];
        $dishes = $this->dishes()->has('ratings')->withAvg('ratings', 'value')->get();
        foreach ($dishes as $dish) {
            array_push($ratings, (float)$dish->ratings_avg_value);
        }
        return count($ratings) ? array_sum($ratings) / count($ratings) : null;
    }

    public function cooks()
    {
        return $this->hasMany(Cook::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
