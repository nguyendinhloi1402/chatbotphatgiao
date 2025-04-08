<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/chat'; 

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
