<?php

namespace Accentinteractive\LaravelBlocker\Database\Factories;

use Accentinteractive\LaravelBlocker\Models\BlockedIp;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlockedIpFactory extends Factory
{

    protected $model = BlockedIp::class;

    public function definition()
    {
        return [
            'ip' => '127.0.0.1',
            'expires_at' => date('Y-m-d H:i:s', strtotime('+'.config('laravel-blocker.expiration_time').' seconds')),
        ];
    }
}
