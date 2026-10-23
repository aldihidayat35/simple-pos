<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Blade Directives for PRD HPP and Role Protection
        Blade::if('canViewHpp', function () {
            return auth()->check() && auth()->user()->canViewHpp();
        });

        Blade::if('cannotViewHpp', function () {
            return !auth()->check() || !auth()->user()->canViewHpp();
        });

        Blade::if('canViewProfit', function () {
            return auth()->check() && auth()->user()->canViewProfit();
        });

        Blade::if('isReadOnly', function () {
            return auth()->check() && auth()->user()->isReadOnly();
        });

        Blade::if('hasRole', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });
    }
}
