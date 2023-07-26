<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if($role == 'customer' && !auth()->user->hasRole('customer')){
            auth()->user->attach_customer();
        }
        $roles = is_array($role) ? $role : explode('|', $role);
        if(!auth()->user->hasRole($roles)){
            throw new CustomException('Forbidden', 403);
        }
        return $next($request);
    }
}
