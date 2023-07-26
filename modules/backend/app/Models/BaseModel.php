<?php

namespace App\Models;

use App\Builders\BaseBuilder;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    public function newEloquentBuilder($query)
    {
        return new BaseBuilder($query);
    }
}
