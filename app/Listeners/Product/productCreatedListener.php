<?php

namespace App\Listeners\Product;

use App\Events\Product\productCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class productCreatedListener
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
     * @param  \App\Events\Product\productCreated  $event
     * @return void
     */
    public function handle(productCreated $event)
    {
        //
    }
}
