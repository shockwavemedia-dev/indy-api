<?php

namespace App\Services\Redis\Interfaces;

use Predis\Client;

interface RedisClientResolverInterface
{
    public function resolve(): Client;
}
