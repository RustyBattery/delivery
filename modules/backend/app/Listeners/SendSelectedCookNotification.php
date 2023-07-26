<?php

namespace App\Listeners;

use App\Events\OrderSelectedCook;
use App\Jobs\CreateNotificationJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSelectedCookNotification
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
     * @param  \App\Events\OrderSelectedCook  $event
     * @return void
     */
    public function handle(OrderSelectedCook $event)
    {
        $order = $event->order;
        $cook = $order->cook;
        $data = [
            'user_id' => $cook->user_id,
            'order_id' => $order->id,
            'message' => 'Вы назначены на заказ №'.$order->id,
        ];
        CreateNotificationJob::dispatch($data);
    }
}
