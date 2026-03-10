<?php

namespace App\Providers;

use App\Repositories\Contracts\StockRepositoryInterface;
use App\Repositories\Eloquent\StockRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /*
    |--------------------------------------------------------------------------
    | register — bind Interface → Concrete Repository
    | Same pattern: UserRepositoryInterface → UserRepository
    |--------------------------------------------------------------------------
    */

    public function register(): void
    {
        $this->app->bind(
            StockRepositoryInterface::class,
            StockRepository::class,
        );
    }

    public function boot(): void
    {
        //
    }
}
