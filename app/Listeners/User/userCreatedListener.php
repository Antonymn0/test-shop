<?php

namespace App\Listeners\User;

use App\Events\User\userCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class userCreatedListener
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
     * @param  \App\Events\User\userCreated  $event
     * @return void
     */
    public function handle(userCreated $event)
    {
        //
    }
}
