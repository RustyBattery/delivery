<?php

namespace App\Models;

use App\Events\NotificationCreate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'status',
        'message',
    ];

    protected static function booted()
    {
        static::created(function ($notification) {
            NotificationCreate::dispatch($notification);
            $notification->status = 'sent';
            $notification->save();
        });
    }
}
