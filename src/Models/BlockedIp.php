<?php

namespace Accentinteractive\LaravelBlocker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedIp extends Model
{

    use HasFactory;

    public $timestamps = false;

    protected $table = 'ai_blocked_ips';

    protected $fillable = [
        'ip',
        'created_at',
    ];

    public function hasExpired()
    {
        return $this->created_at < date('Y-m-d H:i:s', strtotime('-' . (config('laravel-blocker.expiration_time')) . ' seconds'));
    }

    protected static function newFactory()
    {
        return \Accentinteractive\LaravelBlocker\Database\Factories\BlockedIpFactory::new();
    }
}
