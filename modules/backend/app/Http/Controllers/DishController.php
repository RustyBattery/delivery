<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use App\Http\Resources\DishResource;
use App\Http\Resources\RatingResource;
use App\Models\Dish;
use App\Models\Menu;
use App\Models\Rating;
use Illuminate\Http\Request;

class DishController extends Controller
{
    public function index(BaseRequest $request)
    {
        $data = $request->validated();
        $dishes = Dish::with('category')->getBase($data);
        $meta = $dishes["meta"] ?? [];
        return response(array_merge(["data" => DishResource::collection($dishes["data"])], $meta), 200);
    }

    public function menus_dish(Menu $menu, BaseRequest $request)
    {
        $data = $request->validated();
        $filter = [
            "field" => "menu_id",
            "operator" => "=",
            "values" => [$menu->id],
        ];
        if (!isset($data['filters'])) {
            $data['filters'] = [];
        }
        array_push($data['filters'], $filter);

        $dishes = Dish::getBase($data);
        $meta = $dishes["meta"] ?? [];
        return response(array_merge(["data" => DishResource::collection($dishes["data"])], $meta), 200);
    }

    public function dish_rating(Dish $dish, BaseRequest $request)
    {
        $data = $request->validated();
        $ratings = $dish->ratings()->getBase($data);
        $meta = $ratings["meta"] ?? [];
        return response(array_merge(["data" => RatingResource::collection($ratings["data"])], $meta), 200);
    }
}
