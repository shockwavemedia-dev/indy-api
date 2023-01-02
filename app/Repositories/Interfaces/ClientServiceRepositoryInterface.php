<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Client;
use App\Models\ClientService;
use App\Models\Service;
use App\Services\ClientServices\Resources\CreateClientServiceResource;
use App\Services\ClientServices\Resources\UpdateClientServiceResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ClientServiceRepositoryInterface
{
    public function createClientService(CreateClientServiceResource $resource): ClientService;

    public function getClientServices(Client $client, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function increaseTotalUsageByClientService(ClientService $clientService): void;

    public function updateClientService(
        ClientService $clientService,
        UpdateClientServiceResource $resource
    ): ClientService;

    public function updateClientsExtrasByService(Service $service): void;
}
