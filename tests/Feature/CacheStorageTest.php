<?php

namespace Accentinteractive\LaravelBlocker\Tests\Feature;

use Accentinteractive\LaravelBlocker\Facades\BlockedIpStore;
use Accentinteractive\LaravelBlocker\Services\BlockedIpStoreCache;
use Accentinteractive\LaravelBlocker\Tests\TestCase;

/**
 * Class LogCleanerTest
 */
class CacheStorageTest extends TestCase
{

    const IP_ADDRESS = '127.0.0.1';

    public function setUp(): void
    {
        parent::setUp();
        $this->app->singleton('blockedipstore', function () {
            return new BlockedIpStoreCache();
        });
    }

    /** @test */
    public function itCanStoreABlockedIpInStorage()
    {
        BlockedIpStore::create(self::IP_ADDRESS);
        $this->assertSame(true, BlockedIpStore::has(self::IP_ADDRESS));
    }

    /** @test */
    public function itCanCheckIfAnIpAddressIsBlockedInStorage()
    {
        BlockedIpStore::create(self::IP_ADDRESS);
        $this->assertSame(true, BlockedIpStore::has(self::IP_ADDRESS));
    }

    /** @test */
    public function itCanDeleteABlockedIpFromStorage()
    {
        BlockedIpStore::create(self::IP_ADDRESS);
        BlockedIpStore::delete(self::IP_ADDRESS);
        $this->assertSame(false, BlockedIpStore::has(self::IP_ADDRESS));
    }

    /** @test */
    public function itDeletesABlockedIpWhenItHasExpired()
    {
        BlockedIpStore::create(self::IP_ADDRESS, -1);
        BlockedIpStore::has(self::IP_ADDRESS);
        $this->assertSame(false, BlockedIpStore::has(self::IP_ADDRESS));
    }
}
