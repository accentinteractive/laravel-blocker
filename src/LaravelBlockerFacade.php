<?php

namespace Accentinteractive\LaravelBlocker;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Accentinteractive\LaravelBlocker\LaravelBlocker
 */
class LaravelBlockerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-blocker';
    }
}
