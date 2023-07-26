<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
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

    public function cooks()
    {
        return $this->hasMany(Cook::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class);
    }
}
