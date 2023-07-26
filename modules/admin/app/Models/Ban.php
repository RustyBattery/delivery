<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_auth';

    protected $fillable = [
        'user_id',
        'reason',
        'end_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
