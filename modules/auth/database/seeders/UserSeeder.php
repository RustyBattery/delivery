<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = User::create(['name'=>'customer', 'email'=>'customer@mail.ru', 'phone'=>'+7(999)999-99-99', 'password'=>Hash::make('customer')]);
        $courier = User::create(['name'=>'courier', 'email'=>'courier@mail.ru', 'phone'=>'+7(999)999-99-99', 'password'=>Hash::make('courier')]);
        $courier->roles()->attach(Role::where('slug', 'courier')->first());
        $manager = User::create(['name'=>'manager', 'email'=>'manager@mail.ru', 'phone'=>'+7(999)999-99-99', 'password'=>Hash::make('manager')]);
        $manager->roles()->attach(Role::where('slug', 'manager')->first());
        $cook = User::create(['name'=>'cook', 'email'=>'cook@mail.ru', 'phone'=>'+7(999)999-99-99', 'password'=>Hash::make('cook')]);
        $cook->roles()->attach(Role::where('slug', 'cook')->first());
        $admin = User::create(['name'=>'admin', 'email'=>'admin@mail.ru', 'phone'=>'+7(999)999-99-99', 'password'=>Hash::make('admin')]);
        $admin->roles()->attach(Role::where('slug', 'admin')->first());
    }
}
