<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

use App\Services\InventoryService;
use App\Services\ProductService;
use App\Services\GatewayService;

class MicroServiceProvider extends ServiceProvider implements DeferrableProvider
{

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        GatewayService::class => GatewayService::class,
        ProductService::class => ProductService::class,
        InventoryService::class => InventoryService::class,

    ];


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {


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


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            GatewayService::class,
            ProductService::class,
            InventoryService::class,

        ];
    }

}
