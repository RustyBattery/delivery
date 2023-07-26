<?php

namespace App\Models;

use App\Exceptions\CustomException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "address"
    ];

    protected $hidden = [
        'user_id'
    ];

    public function dishes_in_cart()
    {
        return $this->belongsToMany(Dish::class, 'dish_in_carts')->withPivot('count')->withTimestamps();
    }

    public function get_cart_price()
    {
        $price = 0;
        $dishes = $this->dishes_in_cart()->get();
        foreach ($dishes as $dish) {
            $price += $dish->price * $dish->pivot->count;
        }
        return $price;
    }

    public function add_dish_to_cart(Dish $dish)
    {
        $dish_in_cart = $this->dishes_in_cart()->find($dish->id);
        if ($dish_in_cart) {
            $this->dishes_in_cart()->updateExistingPivot($dish->id, ["count" => $dish_in_cart->pivot->count + 1]);
        } else $this->dishes_in_cart()->attach($dish->id);
        return true;
    }

    public function change_count_dish_in_cart(Dish $dish, $count)
    {
        $dish_in_cart = $this->dishes_in_cart()->find($dish->id);
        if (!$dish_in_cart && $count > 0) {
            $this->dishes_in_cart()->attach($dish->id, ["count" => $count]);
            return true;
        }
        if ($dish_in_cart) {
            if ($count == 0) {
                $this->dishes_in_cart()->detach($dish->id);
                return true;
            }
            $this->dishes_in_cart()->updateExistingPivot($dish->id, ["count" => $count]);
        }
        return true;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function order_create($data)
    {
        $data["customer_id"] = $this->id;
        if (!isset($data['address']) && !$this->address) {
            throw new CustomException("Address is required (customer address is null)", 422);
        }
        if(!isset($data['address'])){
            $data['address'] = $this->address;
        }
        $dishes = $this->dishes_in_cart()->get();
        $restaurants = [];
        foreach ($dishes as $dish) {
            $restaurant = $dish->restaurant();
            if (!in_array($restaurant->id, $restaurants)) {
                $order = Order::query()->create(array_merge($data, ["restaurant_id" => $restaurant->id]));
                array_push($restaurants, $restaurant->id);
            }
            $order->dishes()->attach($dish->id, ['count' => $dish->pivot->count, 'price' => $dish->price * $dish->pivot->count]);
            $order->price += $dish->price * $dish->pivot->count;
            $order->save();
            $this->dishes_in_cart()->detach($dish->id);
        }
        return $order;
    }

    public function check_create_rating(Dish $dish)
    {
        if($this->ratings()->where('dish_id', $dish->id)->count()){
            return false;
        }
        $orders = $this->orders()->where('status', 'Delivered')->pluck('id');
        $check = DB::table('dish_in_orders')->where('dish_id', $dish->id)->whereIn('order_id', $orders)->count();
        return (bool)$check;
    }

    public function rating_dishes()
    {
        return $this->belongsToMany(Dish::class, 'ratings')->withPivot('value', 'text')->withTimestamps();
    }
}
