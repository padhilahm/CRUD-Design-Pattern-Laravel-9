<?php

namespace App\Providers;

use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;
use App\Services\Impl\ProductServiceImpl;

class ProductServiceProvider extends ServiceProvider
{
    public array $singletons = [
        ProductService::class => ProductServiceImpl::class
    ];

    public function provides(): array
    {
        return [ProductService::class];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
