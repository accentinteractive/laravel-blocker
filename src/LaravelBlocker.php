<?php

namespace Accentinteractive\LaravelBlocker;

use Accentinteractive\LaravelBlocker\Models\BlockedIp;

class LaravelBlocker
{

    public function isMailicousRequest(): bool
    {
        return $this->isMaliciousUri(request()->fullUrl());
    }

    public function isMaliciousUri(string $uri): bool
    {
        $search = preg_quote(config('laravel-blocker.malicious_urls'), '/');
        $search = str_replace('\|', '|', $search);
        preg_match('/(' . $search . ')/i', $uri, $matches);

        if (empty($matches)) {
            return false;
        }

        return true;
    }
}
