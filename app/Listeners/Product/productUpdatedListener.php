<?php

namespace App\Listeners\Product;

use App\Events\Product\productUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class productUpdatedListener
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
     * @param  \App\Events\Product\productUpdated  $event
     * @return void
     */
    public function handle(productUpdated $event)
    {
        //
    }
}
