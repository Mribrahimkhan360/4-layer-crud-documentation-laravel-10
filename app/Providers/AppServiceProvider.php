<?php

namespace App\Providers;

use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\OrderDetailRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\StockRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

use App\Repositories\Eloquents\AdminRepository;
use App\Repositories\Eloquents\OrderDetailRepository;
use App\Repositories\Eloquents\OrderRepository;
use App\Repositories\Eloquents\StockRepository;
use App\Repositories\Eloquents\BrandRepository;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\PermissionRepository;
use App\Repositories\Eloquents\RoleRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(StockRepositoryInterface::class, StockRepository::class);

        // --- Order ---
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);

        // --- OrderDetail ---
        $this->app->bind(OrderDetailRepositoryInterface::class, OrderDetailRepository::class);
//        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
