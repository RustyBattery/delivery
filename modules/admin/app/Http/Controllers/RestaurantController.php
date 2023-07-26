<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{

    public function index()
    {
        $response = [
            'restaurants' => Restaurant::paginate(10),
        ];
        return view('restaurants.index', $response);
    }

    public function create()
    {
        return view('restaurants.create');
    }

    public function store(RestaurantRequest $request)
    {
        $data = $request->validated();
        $restaurant = Restaurant::create($data);
        return redirect(route('restaurant.show', [$restaurant->id]));
    }

    public function show(Restaurant $restaurant)
    {
        $response = ['restaurant' => $restaurant];
        $response['restaurant']->manager_count = $restaurant->managers()->count();
        $response['restaurant']->cook_count = $restaurant->cooks()->count();
        $response['restaurant']->menus = $restaurant->menus;
        foreach ($response['restaurant']->menus as $menu){
            $menu->count_dish = $menu->dishes()->count();
        }

        return view('restaurants.show', $response);
    }

    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        $data = $request->validated();
        $restaurant->update($data);
        return redirect(route('restaurant.show', [$restaurant->id]));
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect(route('restaurant.index'));
    }

    public function cook_index(Restaurant $restaurant){
        $cooks = $restaurant->cooks()->pluck('user_id')->toArray();
        $response = [
            'restaurant' => $restaurant,
            'cooks' => User::whereIn('id', $cooks)->get(),
        ];
        return view('staff.cooks.index', $response);
    }

    public function manager_index(Restaurant $restaurant){
        $managers = $restaurant->managers()->pluck('user_id')->toArray();
        $response = [
            'restaurant' => $restaurant,
            'managers' => User::whereIn('id', $managers)->get(),
        ];
        return view('staff.managers.index', $response);
    }
}
