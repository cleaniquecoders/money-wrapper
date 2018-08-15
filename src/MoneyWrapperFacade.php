<?php

namespace CleaniqueCoders\MoneyWrapper;

/*
 * This file is part of money-wrapper
 *
 * @license MIT
 * @package money-wrapper
 */

use Illuminate\Support\Facades\Facade;

class MoneyWrapperFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'MoneyWrapper';
    }
}
