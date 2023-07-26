<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\DishInCartResource;
use App\Models\Dish;
use App\Models\Order;
use http\Env\Response;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function get()
    {
        return response(CustomerResource::make(auth()->user->customer()), 200);
    }

    public function update(CustomerRequest $request)
    {
        $customer = auth()->user->customer();
        $data = $request->validated();
        $customer->update($data);
        return response(["message" => "Succsess"], 200);
    }

    public function get_dishes_in_cart()
    {
        $customer = auth()->user->customer();
        return response(["dishes" => DishInCartResource::collection($customer->dishes_in_cart()->get()), "total_price" => $customer->get_cart_price()], 200);
    }

    public function add_dish_to_cart(Dish $dish)
    {
        $customer = auth()->user->customer();
        if ($customer->add_dish_to_cart($dish)) {
            return response(["message" => "Succsess"], 200);
        }
        return response(["message" => "error"], 400);
    }

    public function remove_dish_from_cart(Dish $dish)
    {
        $customer = auth()->user->customer();
        if ($customer->change_count_dish_in_cart($dish, 0)) {
            return response(["message" => "Succsess"], 200);
        }
        return response(["message" => "error"], 400);
    }

    public function change_count_dish_in_cart(Dish $dish, CartRequest $request)
    {
        $data = $request->validated();
        $customer = auth()->user->customer();
        if ($customer->change_count_dish_in_cart($dish, $data["count"])) {
            return response(["message" => "Succsess"], 200);
        }
        return response(["message" => "error"], 400);
    }
}
