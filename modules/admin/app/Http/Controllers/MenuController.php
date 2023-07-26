<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function create()
    {
        $response = [
            'restaurants' => Restaurant::all(),
        ];
        return view('menus.create', $response);
    }

    public function store(MenuRequest $request)
    {
        $data = $request->validated();
        $menu = Menu::create($data);
        return redirect(route('menu.show', [$menu->id]));
    }

    public function show(Menu $menu)
    {
        $response = [
            'restaurants' => Restaurant::all(),
            'menu' => $menu,
        ];
        $response['menu']->dishes = $menu->dishes;
        return view('menus.show', $response);
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $data = $request->validated();
        $menu->update($data);
        return redirect(route('menu.show', [$menu->id]));
    }

    public function destroy(Menu $menu)
    {
        $restaurant = $menu->restaurant;
        $menu->delete();
        return redirect(route('restaurant.show', [$restaurant->id]));
    }
}
