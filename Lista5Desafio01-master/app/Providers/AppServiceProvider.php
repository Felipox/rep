<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Domain\Users\UserRepositoryInterface::class,
        \App\Infrastructure\Eloquent\UserEloquentRepository::class);

        $this->app->bind(
            \App\Domain\Orders\OrderRepositoryInterface::class,
            \App\Infrastructure\Eloquent\OrderEloquentRepository::class);

        $this->app->bind(
            \App\Domain\Notification\NotificationLogRepositoryInterface::class,
            \App\Infrastructure\Eloquent\NotificationLogEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
