<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Database\Seeders\EssentialDataSeeder;

class EssentialDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(EssentialDataSeeder::class, function ($app) {
            return new EssentialDataSeeder();
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
