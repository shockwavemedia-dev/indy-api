<?php

declare(strict_types=1);

namespace App\Services\ClientServices\Interfaces;

use App\Models\Client;
use App\Models\User;

interface ClientServiceFactoryInterface
{
    public function make(Client $client, User $user): void;
}
