<?php

namespace CleaniqueCoders\MoneyWrapper;

use Illuminate\Support\ServiceProvider;

class MoneyWrapperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $config = __DIR__ . '/../config/currency.php';
        $this->mergeConfigFrom($config, 'currency');
        $this->publishes([__DIR__ . '/../config/currency.php' => config_path('currency.php')], 'money-wrapper-config');
    }
}
