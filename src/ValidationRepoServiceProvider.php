<?php

namespace Konsulting\Laravel\ValidationRepo;

use App\User;
use Illuminate\Support\ServiceProvider;

class ValidationRepoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ValidationRepo::class, function () {
            return (new ValidationRepo());
        });
    }
}
