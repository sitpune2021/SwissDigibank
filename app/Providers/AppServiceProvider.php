<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Menu;

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
        // ✅ Fix for MySQL key too long issue
        Schema::defaultStringLength(191);

        // Sidebar composer
        View::composer('layouts.sidebar', function ($view) {
            $view->with('menu', Menu::all());
        });
    }
}
