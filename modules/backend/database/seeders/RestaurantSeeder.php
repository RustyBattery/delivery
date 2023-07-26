<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $makeLove = Restaurant::create(["name" => "Make Love Pizza", "description" => "Make Love Pizza - это 20 видов пиццы на любой вкус: с ветчиной, с беконом, с цыпленком, вегетарианские и тд."]);
        $baseMenu = $makeLove->menus()->create(["name" => "Основное меню", "description" => "Та самая классика"]);
        $seasonMenu = $makeLove->menus()->create(["name" => "Сезонное меню", "description" => "Сезонные напитки и закуски"]);
        $dishes = [
            ["name" => "Кевин", "description" => "Сыры чеддер, дор-блю, гауда, фета, пармезан и конечно, моцарелла на томатном соусе и вкуснейшем тесте! Супер сырная пицца только для тебя одного;)", "menu_id" => $baseMenu->id, "is_vegetarian" => false, "price" => 49500, "category_id" => Category::where("name", "Пицца")->first()->id],
            ["name" => "Мардж", "description" => "Сыр «Моцарелла» (мноооогоо сыраа), томаты, пицца-соус, базилик", "menu_id" => $baseMenu->id, "is_vegetarian" => true, "price" => 32500, "category_id" => Category::where("name", "Пицца")->first()->id],
            ["name" => "Куарежма", "description" => "Молоко, мороженка, горький шоколад", "menu_id" => $baseMenu->id, "is_vegetarian" => false, "price" => 26500, "category_id" => Category::where("name", "Напитки")->first()->id],
            ["name" => "Каприз", "description" => "Легкая закуска из свежих томатов, листьев салата и живой моцареллы с микрозеленью подсолнечника", "menu_id" => $seasonMenu->id, "is_vegetarian" => true, "price" => 36500, "category_id" => Category::where("name", "Салаты")->first()->id],
            ["name" => "Свит кисс", "description" => "Песочная основа, клубничная начика и нежный крем из белого шоколада и маракуйи", "menu_id" => $seasonMenu->id, "is_vegetarian" => false, "price" => 29500, "category_id" => Category::where("name", "Десерты")->first()->id],
            ["name" => "Дача", "description" => "Курица гриль, редис, пеппероната, петрушка, моцарелла и соус чимичурри", "menu_id" => $seasonMenu->id, "is_vegetarian" => false, "price" => 49500, "category_id" => Category::where("name", "Пицца")->first()->id],
        ];
        foreach ($dishes as $dish){
            Dish::create($dish);
        }



        $sushiMore = Restaurant::create(["name" => "Суши Море", "description" => "Суши Море - это современный суши-бар и качественная доставка в Томске. Мы предлагаем готовить для Вас роллы, суши, лапшу ВОК, а также Супы Том Ям."]);
        $menu = $sushiMore->menus()->create(["name" => "Меню", "description" => "Роллы, суши, вок, том ям"]);
        $dishes = [
            ["name" => "Ролл Филадельфия", "description" => "Состав: Лосось, сливочный сыр.", "menu_id" => $menu->id, "is_vegetarian" => false, "price" => 50000, "category_id" => Category::where("name", "Роллы")->first()->id],
            ["name" => "Терияке темпура", "description" => "Состав: Лосось терияке, зеленый лук, сливочный сыр, соус КимЧи, панировка.", "menu_id" => $menu->id, "is_vegetarian" => false, "price" => 26000, "category_id" => Category::where("name", "Роллы")->first()->id],
            ["name" => "Том Ям", "description" => "Состав: Острый бульон Том Ям, кокосовое молоко, галангал, лемонграсс, грибы шампиньоны свежие, помидоры,  рис, начинка на выбор.", "menu_id" => $menu->id, "is_vegetarian" => false, "price" => 22000, "category_id" => Category::where("name", "Супы")->first()->id],
            ["name" => "Вок №14 с креветками", "description" => "Состав: Креветка тигровая, лук, морковь, перец болгарский, соус Терияки, кунжут, зеленый лук", "menu_id" => $menu->id, "is_vegetarian" => false, "price" => 28500, "category_id" => Category::where("name", "Вок")->first()->id],
            ["name" => "Сендвич с лососем", "description" => "Состав: Лосось, сливочный сыр, огурец, кунжут", "menu_id" => $menu->id, "is_vegetarian" => false, "price" => 28000, "category_id" => Category::where("name", "Закуски")->first()->id],
        ];
        foreach ($dishes as $dish){
            Dish::create($dish);
        }
    }
}
