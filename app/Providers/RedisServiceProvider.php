<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Redis\Interfaces\RedisClientResolverInterface;
use App\Services\Redis\Resolvers\RedisClientResolver;
use Illuminate\Support\ServiceProvider;

final class RedisServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            RedisClientResolverInterface::class => RedisClientResolver::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
