<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ["name" => "Салаты", "description" => "Описание категории Салаты"],
            ["name" => "Закуски", "description" => "Описание категории Закуски"],
            ["name" => "Супы", "description" => "Описание категории Супы"],
            ["name" => "Пицца", "description" => "Описание категории Пицца"],
            ["name" => "Роллы", "description" => "Описание категории Роллы"],
            ["name" => "Вок", "description" => "Описание категории Вок"],
            ["name" => "Напитки", "description" => "Описание категории Напитки"],
            ["name" => "Десерты", "description" => "Описание категории Десерты"],
        ];
        foreach ($categories as $category){
            Category::create($category);
        }
    }
}
