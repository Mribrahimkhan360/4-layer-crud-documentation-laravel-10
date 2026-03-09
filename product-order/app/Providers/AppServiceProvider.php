<?php

namespace App\Providers;

use App\Repositories\Contracts\ProductOrderRepositoryInterface;
use App\Repositories\Eloquent\ProductOrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /*
    |--------------------------------------------------------------------------
    | register — bind Interface → Concrete Repository
    |--------------------------------------------------------------------------
    */

    public function register(): void
    {
        $this->app->bind(
            ProductOrderRepositoryInterface::class,
            ProductOrderRepository::class,
        );
    }

    public function boot(): void
    {
        //
    }
}
