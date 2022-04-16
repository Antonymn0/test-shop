<?php

namespace App\Listeners\User;

use App\Events\User\userDestroyed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class userDestroyedListener
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
     * @param  \App\Events\User\userDestroyed  $event
     * @return void
     */
    public function handle(userDestroyed $event)
    {
        //
    }
}
