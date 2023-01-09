<?php

namespace Accentinteractive\LaravelBlocker\Services;

use Accentinteractive\LaravelBlocker\Models\BlockedIp;
use Illuminate\Support\Facades\Cache;

class BlockedIpStoreCache implements BlockedIpStoreInterface
{

    public function create(string $ip, int $expirationTimeInSeconds = null): BlockedIpStoreInterface
    {
        Cache::add($this->getCacheKey($ip), 'blocked', $this->getExpirationTime($expirationTimeInSeconds));

        return $this;
    }

    public function delete(string $ip): BlockedIpStoreInterface
    {
        Cache::forget($this->getCacheKey($ip));

        return $this;
    }

    public function has(string $ip): bool
    {
        if (Cache::has($this->getCacheKey($ip)) === false) {
            return false;
        }

        return true;
    }

    /**
     * @param int|null $expirationTimeInSeconds
     *
     * @return string
     */
    protected function getExpirationTime(?int $expirationTimeInSeconds): int
    {
        $expirationTimeInSeconds = $expirationTimeInSeconds ?: config('laravel-blocker.expiration_time');

        return $expirationTimeInSeconds;
    }

    protected function getCacheKey($ip)
    {
        return 'blocked:' . $ip;
    }
}
