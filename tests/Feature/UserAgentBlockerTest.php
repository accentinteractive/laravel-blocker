<?php

namespace Accentinteractive\LaravelBlocker\Tests\Feature;

use Accentinteractive\LaravelBlocker\Exceptions\MaliciousUserAgentException;
use Accentinteractive\LaravelBlocker\Http\Middleware\BlockMaliciousUsers;
use Accentinteractive\LaravelBlocker\LaravelBlockerFacade as LaravelBlocker;
use Accentinteractive\LaravelBlocker\Models\BlockedIp;
use Accentinteractive\LaravelBlocker\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

/**
 * Class LogCleanerTest
 */
class UserAgentBlockerTest extends TestCase
{

    use RefreshDatabase;

    const HOST = 'https://example.com';
    const IP_ADDRESS = '123.456.78.90';

    /** @test */
    public function itDeterminesUserAgentFromRequest()
    {
        $this->assertSame('Symfony', LaravelBlocker::getUserAgent());
    }

    /** @test */
    public function itDeterminesMaliciousUserAgent()
    {
        config(['laravel-blocker.malicious_user_agents' => 'symfony']);
        $this->assertSame(true, LaravelBlocker::isMaliciousUserAgent());

        config(['laravel-blocker.malicious_user_agents' => 'GoogleBot|BingBot']);
        $this->assertSame(false, LaravelBlocker::isMaliciousUserAgent());
    }

    /** @test */
    public function middlewareStoresIpOnMaliciousUserAgent()
    {
        config(['laravel-blocker.malicious_user_agents' => 'symfony']);
        $this->get(self::HOST);
        $request = new Request();
        request()->server->add(['REMOTE_ADDR' => self::IP_ADDRESS]);

        try {
            (new BlockMaliciousUsers())->handle($request, function ($request) {});
        } catch (MaliciousUserAgentException $e) {
            $this->assertSame(self::IP_ADDRESS, BlockedIp::limit(1)->first()->ip);
        }
    }
}
