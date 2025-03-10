<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthService;
use App\Repositories\AuthRepository;
use App\Services\ProductService;
use App\Repositories\ProductRepository;
use App\Services\AdminService;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\AdminServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Привязка интерфейсов к реализациям
        $this->app->bind(AdminServiceInterface::class, AdminService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);

        // Привязка репозиториев
        $this->app->bind(AuthRepository::class, function ($app) {
            return new AuthRepository();
        });
    
        $this->app->bind(ProductRepository::class, function ($app) {
            return new ProductRepository();
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
