<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema; // ✅ Add this line
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
        //  Fix for "Specified key was too long" error
        Schema::defaultStringLength(191);

        // Share menu data with sidebar view
        View::composer('layouts.sidebar', function ($view) {
            $view->with('menu', Menu::all());
        });
    }
}
