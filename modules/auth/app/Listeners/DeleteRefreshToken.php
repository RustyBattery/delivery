<?php

namespace App\Listeners;

use App\Events\CreateRefreshToken;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteRefreshToken implements ShouldQueue
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

    public $delay = 2592000; //30 days

    /**
     * Handle the event.
     *
     * @param \App\Events\CreateRefreshToken $event
     * @return void
     */
    public function handle(CreateRefreshToken $event)
    {
        $token = $event->token;
        $user = User::where("refresh_token", $token)->first();
        if ($user) {
            $user->revoke_refresh_token();
        }
    }
}
