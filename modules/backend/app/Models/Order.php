<?php

namespace App\Models;

use App\Events\OrderStatusChange;
use App\Exceptions\CustomException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "customer_id",
        "courier_id",
        "restaurant_id",
        "cook_id",
        "delivery_time",
        "order_time",
        "address",
        "price",
        "status",
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function cook()
    {
        return $this->belongsTo(Cook::class);
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'dish_in_orders')->withPivot('count', 'price')->withTimestamps();
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function change_status($new_status, User $user)
    {
        $customer = $user->customer();
        $cook = $user->cook();
        $manager = $user->manager();
        $courier = $user->courier();

        switch ($new_status) {
            case 'Kitchen':
                if (!$cook || $this->cook_id != $cook->id) {
                    throw new CustomException("Forbidden", 403);
                }
                if ($this->status != 'Created') {
                    throw new CustomException("Invalid status", 422);
                }
                break;
            case 'Packaging':
                if (!$cook || $this->cook_id != $cook->id) {
                    throw new CustomException("Forbidden", 403);
                }
                if ($this->status != 'Kitchen') {
                    throw new CustomException("Invalid status", 422);
                }
                break;
            case 'Delivery':
                if (!$cook || $this->cook_id != $cook->id) {
                    throw new CustomException("Forbidden", 403);
                }
                if ($this->status != 'Packaging') {
                    throw new CustomException("Invalid status", 422);
                }
                break;
            case 'Delivered':
                if (!$courier || $this->courier_id != $courier->id) {
                    throw new CustomException("Forbidden", 403);
                }
                if ($this->status != 'Delivery') {
                    throw new CustomException("Invalid status", 422);
                }
                break;
            case 'Canceled'://покупатель, курьер, менеджер
                if ($customer && $this->customer_id == $customer->id && $this->status == 'Created') {
                    break;
                }
                if ($courier && $this->courier_id == $courier->id && $this->status == 'Delivery') {
                    break;
                }
                if ($manager && $this->restaurant_id == $manager->restaurant_id) {
                    break;
                }
                throw new CustomException("Forbidden", 403);
            default:
                throw new CustomException("Invalid status", 422);
        }
        $this->status = $new_status;
        $this->save();

        OrderStatusChange::dispatch($this);
    }
}
