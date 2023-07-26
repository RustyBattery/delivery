<?php

namespace App\Http\Controllers;

use App\Events\CreateRefreshToken;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (!$access_token = auth()->attempt($credentials)) {
            return response(["message" => "Password is invalid.", "errors" => ["password" => "Password is invalid."]], 422);
        }
        if (auth()->user()->is_banned) {
            $ban = auth()->user()->active_ban();
            if ($ban) {
                return response([
                    "message" => "User is banned.",
                    "details" => [
                        "reason" => $ban->reason,
                        "end_time" => $ban->end_time
                    ]
                ], 403);
            }
            auth()->user()->update(["is_banned" => false]);
        }
        $refresh_token = auth()->user()->issue_refresh_token();
        return response([
            "access_token" => $access_token,
            "refresh_token" => $refresh_token
        ], 200);
    }

    public function logout()
    {
        auth()->user()->revoke_refresh_token();
        JWTAuth::parseToken()->invalidate();
        return response(['message' => 'Successfully logged out.'], 200);
    }

    public function refresh(Request $request)
    {
        $access_token = auth()->tokenById(auth()->user()->id);
        $refresh_token = auth()->user()->issue_refresh_token();
        return response([
            "access_token" => $access_token,
            "refresh_token" => $refresh_token
        ], 200);
    }
}
