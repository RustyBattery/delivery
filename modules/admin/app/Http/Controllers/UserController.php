<?php

namespace App\Http\Controllers;

use App\Http\Requests\BanRequest;
use App\Http\Requests\FilterUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\Cook;
use App\Models\Courier;
use App\Models\Manager;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(FilterUserRequest $request)
    {
        $data = $request->validated();
        $role = null;
        if (isset($data['role']) && $data['role'] != "customer") {
            $role = Role::query()->where("slug", $data['role'])->first();
        }
        if (isset($data['role']) && $data['role'] == "customer") {
            $users = User::query()->doesntHave('roles')->paginate(10);
        } else {
            $users = $role ? $role->users()->with('roles')->paginate(10) : User::with('roles')->paginate(10);
        }
        $response = [
            'users' => $users,
            'roles' => Role::all(),
        ];
        return view('users.index', $response);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        if(!$data['password']){
            return back()->withErrors([
                'password' => 'The password is required',
            ]);
        }
        $data['password'] = Hash::make($data['password']);
        $user_roles = $data['roles'] ?? null;
        unset($data['roles']);
        $user = User::query()->create($data);
        if ($user_roles) {
            $roles = Role::whereIn('slug', $user_roles)->pluck('id')->toArray();
            $user->roles()->sync($roles);
            if ($user->roles()->where('slug', 'courier') && !Courier::where('user_id', $user->id)->count()) {
                Courier::query()->create(['user_id' => $user->id]);
            }
        }
        return redirect(route('user.show', [$user->id]));
    }

    public function show(User $user)
    {
        $response = [
            'user' => $user,
            'restaurants' => Restaurant::all(),
        ];
        $response['user']->roles = $user->roles()->pluck('slug')->toArray();
        $response['user']->cook = Cook::where('user_id', $user->id)->first();
        $response['user']->manager = Manager::where('user_id', $user->id)->first();
        return view('users.show', $response);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        $has_email = User::where('email', $data['email'])->first();
        if ($has_email && $has_email->id != $user->id) {
            return back()->withErrors([
                'email' => 'The email must be unique',
            ]);
        }
        $data['password'] = $data['password'] ? Hash::make($data['password']) : $user->password;
        $user->update($data);
        if (isset($data['roles'])) {
            $roles = Role::whereIn('slug', $data['roles'])->pluck('id')->toArray();
            $user->roles()->sync($roles);
            if ($user->roles()->where('slug', 'courier') && !Courier::where('user_id', $user->id)->count()) {
                Courier::query()->create(['user_id' => $user->id]);
            }
        }
        return redirect(route('user.show', [$user->id]));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('user.index'));
    }

    public function cook_upsert(Request $request, User $user)
    {
        $data = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        Cook::updateOrCreate(['user_id' => $user->id], $data);

        return redirect(route('user.show', [$user->id]));
    }

    public function cook_delete(User $user)
    {
        $user->roles()->detach(Role::where('slug', 'cook')->first()->id);
        $cook = Cook::where('user_id', $user->id)->first();
        if($cook){
            $cook->delete();
        }
        return redirect(route('user.show', [$user->id]));
    }

    public function manager_upsert(Request $request, User $user)
    {
        $data = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        Manager::updateOrCreate(['user_id' => $user->id], $data);

        return redirect(route('user.show', [$user->id]));
    }

    public function manager_delete(User $user)
    {
        $user->roles()->detach(Role::where('slug', 'manager')->first()->id);
        $manager = Manager::where('user_id', $user->id)->first();
        if($manager){
            $manager->delete();
        }
        return redirect(route('user.show', [$user->id]));
    }
}
