<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\BaseRequest;
use App\Http\Resources\CourierResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function get()
    {
        return response(CourierResource::make(auth()->user->courier()), 200);
    }

    public function get_available_orders(BaseRequest $request)
    {
        $data = $request->validated();
        $orders = Order::query()->whereNull('courier_id')->whereNotNull('order_time')->whereNot('status', 'Canceled')->getBase($data);
        $meta = $orders["meta"] ?? [];
        return response(array_merge(["data" => OrderResource::collection($orders["data"])], $meta), 200);
    }

    public function execute_order(Order $order)
    {
        if ($order->status == 'Canceled' || $order->courier_id) {
            throw new CustomException("Forbidden", 403);
        }
        $order->courier_id = auth()->user->courier()->id;
        $order->save();
        return response(["message" => "Succsess"], 200);
    }

    public function get_orders_history(BaseRequest $request)
    {
        $data = $request->validated();
        $orders = auth()->user->courier()->orders()->getBase($data);
        $meta = $orders["meta"] ?? [];
        return response(array_merge(["data" => OrderResource::collection($orders["data"])], $meta), 200);
    }
}
