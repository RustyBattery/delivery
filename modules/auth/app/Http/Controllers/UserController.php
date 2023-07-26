<?php

namespace App\Http\Controllers;

use App\Events\CreateRefreshToken;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get()
    {
        return response()->json(auth()->user());
    }

    public function create(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        if ($user) {
            $access_token = auth()->tokenById($user->id);
            $refresh_token = $user->issue_refresh_token();
            return response([
                "access_token" => $access_token,
                "refresh_token" => $refresh_token
            ], 200);
        }
    }

    public function update(ProfileUpdateRequest $request)
    {
        $data = $request->validated();
        $data = array_diff($data, array(''));
        auth()->user()->update($data);
        return response()->json(auth()->user());
    }

    public function delete()
    {
        auth()->user()->delete();
        return response(["message" => "Success delete"], 200);
    }
}
