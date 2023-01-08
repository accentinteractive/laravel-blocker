<?php

namespace Accentinteractive\LaravelBlocker\Tests\Feature;

use Accentinteractive\LaravelBlocker\Http\Middleware\BlockMaliciousUsers;
use Accentinteractive\LaravelBlocker\LaravelBlockerFacade as LaravelBlocker;
use Accentinteractive\LaravelBlocker\Models\BlockedIp;
use Accentinteractive\LaravelBlocker\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

/**
 * Class LogCleanerTest
 */
class UriBlockerTest extends TestCase
{

    const HOST = 'https://example.com';

    /** @test */
    public function itDeterminesAMaliciousUrlFromAString()
    {
        config(['laravel-blocker.malicious_urls' => 'call_user_func_array']);
        $this->assertSame(true, LaravelBlocker::isMaliciousUri(self::HOST . '/?invokefunction&function=call_user_func_array&vars[0]=phpinfo'));
    }

    /** @test */
    public function itEscapesRegexCharacters()
    {
        config(['laravel-blocker.malicious_urls' => 'wp-admin']);
        $this->assertSame(true, LaravelBlocker::isMaliciousUri(self::HOST . '/wp-admin/'));

        config(['laravel-blocker.malicious_urls' => '?foo']);
        $this->assertSame(true, LaravelBlocker::isMaliciousUri(self::HOST . '/?foo=bar'));

        config(['laravel-blocker.malicious_urls' => '.git']);
        $this->assertSame(true, LaravelBlocker::isMaliciousUri(self::HOST . '/.git'));
    }

}
