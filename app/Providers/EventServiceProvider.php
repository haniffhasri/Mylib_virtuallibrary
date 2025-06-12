<?php

namespace App\Providers;

use App\Listeners\HandleUserRegistered;
use App\Events\UserRegistered;
use Illuminate\Support\ServiceProvider;
use App\Events\BookAdded;
use App\Listeners\HandleBookRegister;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        UserRegistered::class => [
            HandleUserRegistered::class,
        ],
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
