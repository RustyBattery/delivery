<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Jobs\CreateNotificationJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewOrderNotification
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
     * @param \App\Events\OrderCreated $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        $managers = $order->restaurant->managers()->get();
        foreach ($managers as $manager) {
            $data = [
                'user_id' => $manager->user_id,
                'order_id' => $order->id,
                'message' => 'Новый заказ №'.$order->id,
            ];
            CreateNotificationJob::dispatch($data);
        }
    }
}
