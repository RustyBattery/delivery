<?php

namespace App\Http\Controllers;

use App\Events\OrderSelectedCook;
use App\Exceptions\CustomException;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\CookResource;
use App\Http\Resources\ManagerResource;
use App\Http\Resources\OrderResource;
use App\Models\Cook;
use App\Models\Order;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function get()
    {
        return response(ManagerResource::make(auth()->user->manager()), 200);
    }

    public function get_cooks()
    {
        $cooks = auth()->user->manager()->restaurant->cooks;
        return response(["data" => CookResource::collection($cooks)], 200);
    }

    public function get_orders(BaseRequest $request)
    {
        $data = $request->validated();
        $orders = auth()->user->manager()->restaurant->orders()->getBase($data);
        $meta = $orders["meta"] ?? [];
        return response(array_merge(["data" => OrderResource::collection($orders["data"])], $meta), 200);
    }

    public function order_update(Order $order, OrderUpdateRequest $request)
    {
        $data = $request->validated();
        $cook = Cook::query()->where('id', $data["cook_id"] ?? 0)->where('restaurant_id', auth()->user->manager()->restaurant->id)->count();
        if (!$cook && isset($data["cook_id"])) {
            throw new CustomException("The selected cook id is invalid.", 422);
        }
        $order->update($data);
        if (isset($data["cook_id"])) {
            OrderSelectedCook::dispatch($order);
        }
        return response(["message" => "Succsess"], 200);
    }
}
