<?php

namespace Accentinteractive\LaravelBlocker\Services;

use Accentinteractive\LaravelBlocker\Models\BlockedIp;

class BlockedIpStoreDatabase implements BlockedIpStoreInterface
{

    public function create(string $ip, int $expirationTimeInSeconds = null): BlockedIpStoreInterface
    {
        $expiresAt = $this->getExpirationDateTime($expirationTimeInSeconds);

        BlockedIp::updateOrCreate([
            'ip' => $ip,
            'expires_at' => $expiresAt,
        ]);

        return $this;
    }

    public function delete(string $ip): BlockedIpStoreInterface
    {
        BlockedIp::where('ip', $ip)->delete();

        return $this;
    }

    public function has(string $ip): bool
    {
        $blockedIp = BlockedIp::where('ip', $ip)->first();

        if ($blockedIp === null) {
            return false;
        }

        if ($blockedIp->hasExpired()) {
            BlockedIp::where('ip', $ip)->delete();

            return false;
        }

        return true;
    }

    /**
     * @param int|null $expirationTimeInSeconds
     *
     * @return string
     */
    protected function getExpirationDateTime(?int $expirationTimeInSeconds): string
    {
        $expirationTimeInSeconds = $expirationTimeInSeconds ?: config('laravel-blocker.expiration_time');
        $expiresAt = date('Y-m-d H:i:s', strtotime('+' . $expirationTimeInSeconds . ' seconds'));

        return $expiresAt;
    }
}
