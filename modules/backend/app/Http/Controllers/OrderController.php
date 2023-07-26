<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Exceptions\CustomException;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderShortResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(OrderCreateRequest $request)
    {
        $data = $request->validated();
        $customer = auth()->user->customer();
        if ($order = $customer->order_create($data)) {
            OrderCreated::dispatch($order);
            return response(["message" => "Succsess"], 200);
        }
        return response(["message" => "error"], 400);
    }

    public function customer_orders(BaseRequest $request)
    {
        $data = $request->validated();
        $orders = auth()->user->customer()->orders()->getBase($data);
        $meta = $orders["meta"] ?? [];
        return response(array_merge(["data" => OrderShortResource::collection($orders["data"])], $meta), 200);
    }

    public function customer_order_details(Order $order)
    {
        if ($order->customer != auth()->user->customer()) {
            throw new CustomException("Forbidden", 403);
        }
        return response(OrderResource::make($order), 200);
    }

    public function change_status(Order $order, $status)
    {
        $order->change_status($status, auth()->user);
        return response(["message" => "Succsess"], 200);
    }
}
