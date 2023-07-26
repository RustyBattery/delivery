<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class Refresh
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $refresh_token = $request->bearerToken();
        if(!$refresh_token){
            throw new CustomException('Token is required', 422);
        }
        $user = User::where("refresh_token", $refresh_token)->first();
        if(!$user){
            throw new CustomException('Token Invalid', 422);
        }
        $token = auth()->login($user);
        return $next($request);
    }
}
