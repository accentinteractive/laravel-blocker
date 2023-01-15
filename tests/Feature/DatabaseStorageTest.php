<?php

namespace Accentinteractive\LaravelBlocker\Tests\Feature;

use Accentinteractive\LaravelBlocker\Facades\BlockedIpStore;
use Accentinteractive\LaravelBlocker\Models\BlockedIp;
use Accentinteractive\LaravelBlocker\Services\BlockedIpStoreCache;
use Accentinteractive\LaravelBlocker\Services\BlockedIpStoreDatabase;
use Accentinteractive\LaravelBlocker\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class LogCleanerTest
 */
class DatabaseStorageTest extends TestCase
{

    const IP_ADDRESS = '127.0.0.1';
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->singleton('blockedipstore', function () {
            return new BlockedIpStoreDatabase();
        });

        // import the CreatePostsTable class from the migration
        require_once __DIR__ . '/../../database/migrations/2023_01_08_100000_create_blocked_ips_table.php';

        $this->loadLaravelMigrations(['--database' => 'testing']);
        $this->artisan('migrate', ['--database' => 'testing'])->run();

    }

    /** @test */
    public function itCanStoreABlockedIp()
    {
        BlockedIpStore::create(self::IP_ADDRESS);
        $this->assertSame(true, BlockedIpStore::has(self::IP_ADDRESS));
    }

    /** @test */
    public function itCanCheckIfAnIpAddressHasBeenBlocked()
    {
        BlockedIp::factory()->create(['ip' => self::IP_ADDRESS]);
        $this->assertSame(true, BlockedIpStore::has(self::IP_ADDRESS));
    }

    /** @test */
    public function itCanDeleteABlockedIp()
    {
        BlockedIp::factory()->create(['ip' => self::IP_ADDRESS]);
        BlockedIpStore::delete(self::IP_ADDRESS);
        $this->assertSame(false, BlockedIpStore::has(self::IP_ADDRESS));
    }

    /** @test */
    public function itDeletesABlockedIpWhenItHasExpired()
    {
        $dateInPast = date('Y-m-d H:i:s', strtotime('-1 second'));
        BlockedIp::factory()->create(['ip' => self::IP_ADDRESS, 'expires_at' => $dateInPast]);
        BlockedIpStore::has(self::IP_ADDRESS);
        $this->assertSame(false, BlockedIpStore::has(self::IP_ADDRESS));
    }

}
