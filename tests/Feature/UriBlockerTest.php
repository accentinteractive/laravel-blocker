<?php

namespace Accentinteractive\LaravelBlocker\Tests\Feature;

use Accentinteractive\LaravelBlocker\Exceptions\MaliciousUrlException;
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

    use RefreshDatabase;

    const HOST = 'https://example.com';
    const IP_ADDRESS = '123.456.78.90';

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

    /** @test */
    public function itDeterminesMaliciousUrlFromRequest()
    {
        // Request a malicious URL
        $this->mockMaliciousUrlInRequest();
        $this->assertSame(true, LaravelBlocker::isMailicousRequest());
    }

    /** @test */
    public function middlewareThrowsExceptionOnMaliciousUrl()
    {
        // Request a malicious URL
        $this->mockMaliciousUrlInRequest();
        $this->expectException('Accentinteractive\LaravelBlocker\Exceptions\MaliciousUrlException');

        $request = new Request();
        $request->merge(['ip' => self::IP_ADDRESS]);
        (new BlockMaliciousUsers())->handle($request, function ($request) {
            $this->assertSame(self::IP_ADDRESS, $request->ip());
        });
    }

    /** @test */
    public function middlewareStoresIpOnMaliciousUrl()
    {
        // Request a malicious URL
        $this->mockMaliciousUrlInRequest();

        $request = new Request();
        $request->merge(['ip' => self::IP_ADDRESS]);

        try {
            (new BlockMaliciousUsers())->handle($request, function ($request) {
            });
        } catch (MaliciousUrlException $e) {
            $this->assertSame(self::IP_ADDRESS, BlockedIp::limit(1)->first()->ip);
        }
    }

    /** @test */
    public function middlewareThrowsExceptionOnBlockedIp()
    {
        // Create a blocked user
        BlockedIp::create(['ip' => self::IP_ADDRESS]);

        // Do a request as the user with the blocked IP
        $this->get('https://test.domain.com/');
        request()->server->add(['REMOTE_ADDR' => self::IP_ADDRESS]);

        // Run the BlockMaliciousUsers middleware
        $this->expectException('Accentinteractive\LaravelBlocker\Exceptions\BlockedUserException');
        (new BlockMaliciousUsers())->handle(request(), function ($request) {
        });
    }

    /** @test */
    public function middlewareDeletesExpiredBlockedIp()
    {
        // Create a blocked user whose block has expired
        $expiredCreatedDate = date('Y-m-d H:i:s', strtotime('-' . (config('laravel-blocker.expiration_time') + 10) . ' seconds'));
        BlockedIp::create(['ip' => self::IP_ADDRESS, 'created_at' => $expiredCreatedDate]);

        // Do a request as the user with the blocked IP
        $this->get('https://test.domain.com/');
        request()->server->add(['REMOTE_ADDR' => self::IP_ADDRESS]);

        // Run the BlockMaliciousUsers middleware
        (new BlockMaliciousUsers())->handle(request(), function ($request) {
        });

        // The blocked user should have been deleted adn no exception should have been thrown
        $this->assertSame(null, BlockedIp::first());
    }

    /**
     * @return void
     */
    protected function mockMaliciousUrlInRequest(): void
    {
        config(['laravel-blocker.malicious_urls' => 'wp-admin']);
        $this->get('https://test.domain.com/wp-admin');
        request()->server->add(['REMOTE_ADDR' => self::IP_ADDRESS]);
    }

}
