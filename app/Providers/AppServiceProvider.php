<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthService;
use App\Repositories\AuthRepository;
use App\Services\ProductService;
use App\Repositories\ProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthRepository::class, function ($app) {
            return new AuthRepository();
        });
    
        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService($app->make(AuthRepository::class));
        });


        $this->app->singleton(ProductRepository::class, function ($app) {
            return new ProductRepository();
        });
    
        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
