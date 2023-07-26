<?php

namespace App\Listeners;

use App\Events\OrderStatusChange;
use App\Jobs\CreateNotificationJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewOrderStatusNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderStatusChange  $event
     * @return void
     */
    public function handle(OrderStatusChange $event)
    {
        $order = $event->order;
        $customer = $order->customer;
        $data = [
            'user_id' => $customer->user_id,
            'order_id' => $order->id,
            'message' => 'Заказ №'.$order->id.' статус: '.$order->status,
        ];
        CreateNotificationJob::dispatch($data);
    }
}
