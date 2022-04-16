<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        //  User events
        'App\Events\User\userCreated' => [
            'App\Listeners\User\userCreatedListener',
        ],
        'App\Events\User\userUpdated' => [
            'App\Listeners\User\userUpdatedListener',
        ],
        'App\Events\User\userDestroyed' => [
            'App\Listeners\User\userDestroyedListener',
        ],

        // Product events
        'App\Events\Product\productCreated' => [
            'App\Listeners\Product\productCreatedListener',
        ],
        'App\Events\Product\productUpdated' => [
            'App\Listeners\Product\productUpdatedListener',
        ],
        'App\Events\Product\productDestroyed' => [
            'App\Listeners\Product\productDestroyedListener',
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
}
