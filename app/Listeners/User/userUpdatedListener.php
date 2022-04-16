<?php

namespace App\Listeners\User;

use App\Events\User\userUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class userUpdatedListener
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
     * @param  \App\Events\User\userUpdated  $event
     * @return void
     */
    public function handle(userUpdated $event)
    {
        //
    }
}
