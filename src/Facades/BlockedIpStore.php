<?php

namespace Accentinteractive\LaravelBlocker\Facades;

use Illuminate\Support\Facades\Facade;

class BlockedIpStore extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'blockedipstore';
    }
}
