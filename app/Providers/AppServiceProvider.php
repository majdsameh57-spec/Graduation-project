<?php

namespace App\Providers;

use App\Models\article;
use App\Models\category;
use App\Models\shop;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        //
        Schema::defaultStringLength(191);

        view::composer('Liquidity.home', function ($view) {
            $shopes = shop::latest()
                ->take(4)
                ->get();
            $view->with('shopes', $shopes);
        });
        
    }
}
