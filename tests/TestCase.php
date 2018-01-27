<?php

namespace CleaniqueCoders\MoneyWrapper\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            CleaniqueCoders\MoneyWrapper\MoneyWrapperServiceProvider::class,
        ];
    }
}
