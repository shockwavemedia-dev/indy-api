<?php

declare(strict_types=1);

namespace App\Services\ClientServices\Interfaces;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface ClientServiceUpdateInterface
{
    public function update(Client $client, User $user, array $services): Collection;
}
