<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Share notifications with all views
        View::composer('*', function ($view) {
            $notifications = [];

            if (Auth::check()) {
                $notifications = Auth::user()->unreadNotifications()->take(5)->get();
            }

            $view->with('headerNotifications', $notifications);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
