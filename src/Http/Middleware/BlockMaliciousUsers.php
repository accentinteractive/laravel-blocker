<?php

namespace Accentinteractive\LaravelBlocker\Http\Middleware;

use Accentinteractive\LaravelBlocker\Exceptions\BlockedUserException;
use Accentinteractive\LaravelBlocker\Exceptions\MaliciousUrlException;
use Accentinteractive\LaravelBlocker\Exceptions\MaliciousUserAgentException;
use Accentinteractive\LaravelBlocker\LaravelBlockerFacade as LaravelBlocker;
use Accentinteractive\LaravelBlocker\Models\BlockedIp;
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
        $blockedIp = BlockedIp::where('ip', $requestIp)->first();

        // Is this a blocked IP that has expired?
        if ($this->checkUrlsOrAgents() && $blockedIp && $blockedIp->hasExpired()) {
            BlockedIp::where('ip', $requestIp)->delete();
            $blockedIp = null;
        }

        // Is this a blocked IP?
        if ($this->checkUrlsOrAgents() && $blockedIp) {
            throw new BlockedUserException(__('You have been blocked'), 401);
        }

        // Does this URL contain a malicious string?
        // @see config/config.php
        if ($this->checkForMaliciousUrls && LaravelBlocker::isMailicousRequest()) {
            // Store blocked IP
            BlockedIp::updateOrCreate(['ip' => $requestIp]);

            throw new MaliciousUrlException(__('Not accepted'), 406);
        }

        // Does the request come from a malicious User Agent?
        // @see config/config.php
        if ($this->checkForMaliciousUseragents && LaravelBlocker::isMaliciousUserAgent()) {
            // Store blocked IP
            BlockedIp::updateOrCreate(['ip' => $requestIp]);

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
