<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Brand
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Eloquent\BrandRepository;

// Product
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\ProductRepository;

// Stock
use App\Repositories\Contracts\StockRepositoryInterface;
use App\Repositories\Eloquent\StockRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register repository bindings.
     */
    public function register(): void
    {
        $this->app->bind(BrandRepositoryInterface::class,   BrandRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(StockRepositoryInterface::class,   StockRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
