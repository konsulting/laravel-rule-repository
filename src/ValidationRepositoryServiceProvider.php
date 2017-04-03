<?php

namespace Klever\Laravel\ValidationRepository;

use App\User;
use Illuminate\Support\ServiceProvider;

class ValidationRepositoryServiceProvider extends ServiceProvider
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
        $this->app->singleton(ValidationRepository::class, function () {
            return (new ValidationRepository());
        });
    }
}
