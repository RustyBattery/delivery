<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishRequest;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    public function create(Menu $menu)
    {
        $response = [
            'categories' => Category::all(),
            'menus' => $menu->restaurant->menus,
            'menu_cur' => $menu,
        ];
        return view('dishes.create', $response);
    }

    public function store(DishRequest $request)
    {
        $data = $request->validated();
        $data['price'] = (integer)($data['price']*100);
        if(isset($data['photo'])){
            $data['photo'] = Storage::putFile('dish', $data['photo'], 'public');
        }
        $dish = Dish::create($data);
        return redirect(route('dish.show', [$dish->id]));
//        $url = env('AWS_TAKE_URL').'/'.env('AWS_BUCKET').'/'.$path;
    }

    public function show(Dish $dish)
    {
        $response = [
            'dish' => $dish,
            'categories' => Category::all(),
            'menus' => $dish->restaurant()->menus()->get()
        ];
        $response['dish']->category = $dish->category;
        return view('dishes.show', $response);
    }

    public function update(DishRequest $request, Dish $dish)
    {
        $data = $request->validated();
        $data['price'] = (integer)($data['price']*100);
        if(isset($data['photo'])){
            $data['photo'] = Storage::putFile('dish', $data['photo'], 'public');
        }
        if(!isset($data['is_vegetarian'])){
            $data['is_vegetarian'] = false;
        }
        $dish->update($data);
        return redirect(route('dish.show', [$dish->id]));
    }

    public function destroy(Dish $dish)
    {
        $menu = $dish->menu;
        $dish->delete();
        return redirect(route('menu.show', [$menu->id]));
    }
}
