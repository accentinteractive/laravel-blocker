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

        // import the CreatePostsTable class from the migration
        require_once __DIR__ . '/../database/migrations/2023_01_08_100000_create_blocked_ips_table.php';

        $this->loadLaravelMigrations(['--database' => 'testing']);
        $this->artisan('migrate', ['--database' => 'testing'])->run();
    }
}


