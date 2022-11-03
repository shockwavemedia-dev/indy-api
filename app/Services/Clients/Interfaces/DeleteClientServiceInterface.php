<?php

declare(strict_types=1);

namespace App\Services\Clients\Interfaces;

use App\Enum\ClientStatusEnum;
use App\Models\Client;

interface DeleteClientServiceInterface
{
    public function delete(Client $client, ClientStatusEnum $status): void;
}
