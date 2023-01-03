<?php

namespace App\Services\Clients\Interfaces;

use App\Models\Client;
use App\Services\Clients\Resources\CreateClientResource;

interface ClientCreationServiceInterface
{
    public function create(CreateClientResource $resource): Client;
}
