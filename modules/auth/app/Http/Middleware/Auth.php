<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::getPayload(JWTAuth::getToken());
            return $next($request);
        } catch (TokenExpiredException $exception) {
            throw new CustomException('Token Expired', 401);
        } catch (TokenInvalidException $exception) {
            throw new CustomException('Token Invalid', 401);
        } catch (JWTException $exception) {
            throw new CustomException('Token is Required', 401);
        }
    }
}
