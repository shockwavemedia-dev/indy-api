<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Models\Client;
use App\Models\ClientService;
use App\Models\Service;
use App\Repositories\Interfaces\ClientServiceRepositoryInterface;
use App\Services\ClientServices\Resources\CreateClientServiceResource;
use App\Services\ClientServices\Resources\UpdateClientServiceResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class ClientServiceRepositoryStub extends AbstractStub implements ClientServiceRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function createClientService(CreateClientServiceResource $resource): ClientService
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function getClientServices(Client $client, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function updateClientService(ClientService $clientService, UpdateClientServiceResource $resource): ClientService
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function increaseTotalUsageByClientService(ClientService $clientService): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function updateClientsExtrasByService(Service $service): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }
}
