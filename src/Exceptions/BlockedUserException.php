<?php

namespace Accentinteractive\LaravelBlocker\Exceptions;

class BlockedUserException extends \Exception
{
    protected $code = 406;
}
