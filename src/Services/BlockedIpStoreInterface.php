<?php

namespace Accentinteractive\LaravelBlocker\Services;

interface BlockedIpStoreInterface
{

    public function create(string $ip, int $expirationTimeInSeconds = null): BlockedIpStoreInterface;

    public function delete(string $ip): BlockedIpStoreInterface;

    public function has(string $ip): bool;
}
