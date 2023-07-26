<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Events\OrderSelectedCook;
use App\Events\OrderStatusChange;
use App\Listeners\SendNewOrderNotification;
use App\Listeners\SendNewOrderStatusNotification;
use App\Listeners\SendSelectedCookNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCreated::class => [
            SendNewOrderNotification::class,
        ],
        OrderSelectedCook::class => [
            SendSelectedCookNotification::class,
        ],
        OrderStatusChange::class => [
            SendNewOrderStatusNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
