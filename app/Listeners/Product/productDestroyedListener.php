<?php

namespace App\Listeners\Product;

use App\Events\Product\productDestroyed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class productDestroyedListener
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
     * @param  \App\Events\Product\productDestroyed  $event
     * @return void
     */
    public function handle(productDestroyed $event)
    {
        //
    }
}
