<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\RestaurantShortResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(BaseRequest $request){
        $data = $request->validated();
        $restaurants = Restaurant::getBase($data);
        $meta = $restaurants["meta"] ?? [];
        return response(array_merge(["data" => RestaurantShortResource::collection($restaurants["data"])], $meta), 200);
    }

    public function get(Restaurant $restaurant){
        return response(RestaurantResource::make($restaurant), 200);
    }
}
