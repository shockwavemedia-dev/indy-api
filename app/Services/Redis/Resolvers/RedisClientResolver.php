<?php

declare(strict_types=1);

namespace App\Services\Redis\Resolvers;

use App\Services\Redis\Interfaces\RedisClientResolverInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Predis\Client;

final class RedisClientResolver implements RedisClientResolverInterface
{
    public function resolve(): Client
    {
        $config = Config::get('database.redis.default');

        return new Client([
            'scheme' => 'tcp',
            'database' => Arr::get($config, 'database'),
            'host'   => Arr::get($config, 'host'),
            'port'   => Arr::get($config, 'port'),
        ]);
    }
}
