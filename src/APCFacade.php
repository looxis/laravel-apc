<?php

namespace Looxis\Laravel\APC;

use Illuminate\Support\Facades\Facade;

class APCFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-apc';
    }
}
