<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
use App\Http\Resources\CookResource;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

class CookController extends Controller
{
    public function get()
    {
        return response(CookResource::make(auth()->user->cook()), 200);
    }

    public function get_orders_history(BaseRequest $request)
    {
        $data = $request->validated();
        $orders = auth()->user->cook()->orders()->getBase($data);
        $meta = $orders["meta"] ?? [];
        return response(array_merge(["data" => OrderResource::collection($orders["data"])], $meta), 200);
    }
}
