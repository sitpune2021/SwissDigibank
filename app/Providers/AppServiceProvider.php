<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema; //  Add this line
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
        //  Fix for MySQL key length issue
        Schema::defaultStringLength(191);

        // Existing sidebar composer logic
        View::composer('layouts.sidebar', function ($view) {
            $view->with('menu', Menu::all());
        });

        // ✅ Load PermissionHelper manually so hasPermission() works without composer dump-autoload
        $helperPath = app_path('Helpers/PermissionHelper.php');
        if (file_exists($helperPath)) {
            require_once $helperPath;
        }

    }
    
}
