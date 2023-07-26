<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(["name" => "Курьер", "slug" => "courier"]);
        Role::create(["name" => "Менеджер", "slug" => "manager"]);
        Role::create(["name" => "Повар", "slug" => "cook"]);
        Role::create(["name" => "Администратор", "slug" => "admin"]);
    }
}
