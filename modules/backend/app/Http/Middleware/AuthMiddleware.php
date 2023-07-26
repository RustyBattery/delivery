<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Models\Cook;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Manager;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthMiddleware
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
        $token = $request->bearerToken();
        $response = Http::withToken($token)->post(env('AUTH_MS_URL') . '/api/auth/check');
        if (!$response->ok()) {
            throw new CustomException($response->json()['message'], 401);
        }

        $token = explode('.', $token);
        $payload = json_decode(base64_decode($token[1]));
        $user_roles = [];
        foreach ($payload->roles as $role) {
            $model = null;
            switch ($role) {
                case "courier":
                    $model = Courier::query()->where('user_id', $payload->id)->first();
                    break;
                case "cook":
                    $model = Cook::query()->where('user_id', $payload->id)->first();
                    break;
                case "manager":
                    $model = Manager::query()->where('user_id', $payload->id)->first();
                    break;
            }
            if ($model) {
                $user_roles[$role] = ["id" => $model->id];
            }
        }
        $model = Customer::query()->where('user_id', $payload->id)->first();
        if ($model) {
            $user_roles["customer"] = ["id" => $model->id];
        }
        $data = [
            'id' => $payload->id,
            'name' => $payload->name,
            'email' => $payload->email,
            'roles' => $user_roles,
        ];
        $user = new User($data);
        auth()->user = $user;

        return $next($request);
    }
}
