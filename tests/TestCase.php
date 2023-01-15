<?php

namespace Accentinteractive\LaravelBlocker\Tests;

use Accentinteractive\LaravelBlocker\LaravelBlockerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{

    protected function getPackageProviders($app)
    {
        return [
            LaravelBlockerServiceProvider::class,
        ];
    }

    public function setUp(): void
    {
        parent::setUp();
    }
}


