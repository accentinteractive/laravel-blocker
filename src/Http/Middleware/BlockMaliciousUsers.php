<?php

namespace Accentinteractive\LaravelBlocker\Http\Middleware;

use Accentinteractive\LaravelBlocker\Exceptions\BlockedUserException;
use Accentinteractive\LaravelBlocker\Exceptions\MaliciousUrlException;
use Accentinteractive\LaravelBlocker\Exceptions\MaliciousUserAgentException;
use Accentinteractive\LaravelBlocker\Facades\BlockedIpStore;
use Accentinteractive\LaravelBlocker\Facades\LaravelBlocker;
use Closure;

class BlockMaliciousUsers
{

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected bool $checkForMaliciousUrls;

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected bool $checkForMaliciousUseragents;

    public function __construct()
    {
        $this->checkForMaliciousUrls = (bool) config('laravel-blocker.url_detection_enabled');
        $this->checkForMaliciousUseragents = (bool) config('laravel-blocker.user_agent_detection_enabled');
    }

    public function handle($request, Closure $next)
    {
        $requestIp = request()->ip();

        // Is this a blocked IP?
        if ($this->checkUrlsOrAgents() && BlockedIpStore::has($requestIp)) {
            throw new BlockedUserException(__('You have been blocked'), 401);
        }

        // Does this URL contain a malicious string?
        // @see config/config.php
        if ($this->checkForMaliciousUrls && LaravelBlocker::isMailicousRequest()) {
            // Store blocked IP
            BlockedIpStore::create($requestIp);

            throw new MaliciousUrlException(__('Not accepted'), 406);
        }

        // Does the request come from a malicious User Agent?
        // @see config/config.php
        if ($this->checkForMaliciousUseragents && LaravelBlocker::isMaliciousUserAgent()) {
            // Store blocked IP
            BlockedIpStore::create($requestIp);

            throw new MaliciousUserAgentException(__('Not accepted'), 406);
        }

        return $next($request);
    }

    /**
     * @param mixed $checkForMaliciousUrls
     * @param mixed $checkForMaliciousUseragents
     *
     * @return bool
     */
    protected function checkUrlsOrAgents(): bool
    {
        return $this->checkForMaliciousUrls || $this->checkForMaliciousUseragents;
    }
}
