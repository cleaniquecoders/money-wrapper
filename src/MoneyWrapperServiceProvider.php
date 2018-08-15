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
        /*
         * Configuration
         */
        $this->publishes([
            __DIR__ . '/../config/currency.php' => config_path('currency.php'),
        ], 'money-wrapper-config');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/currency.php', 'currency'
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
