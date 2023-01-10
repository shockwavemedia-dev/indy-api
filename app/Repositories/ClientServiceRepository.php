<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Client;
use App\Models\ClientService;
use App\Models\Service;
use App\Repositories\Interfaces\ClientServiceRepositoryInterface;
use App\Services\ClientServices\Resources\CreateClientServiceResource;
use App\Services\ClientServices\Resources\UpdateClientServiceResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ClientServiceRepository extends BaseRepository implements ClientServiceRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new ClientService());
    }

    public function createClientService(CreateClientServiceResource $resource): ClientService
    {
        return $this->model->create([
            'is_enabled' => false,
            'client_id' => $resource->getClientId(),
            'service_id' => $resource->getServiceId(),
            'extras' => $resource->getExtras(),
            'created_by' => $resource->getCreatedById(),
        ]);
    }

    public function increaseTotalUsageByClientService(ClientService $clientService): void
    {
        $clientService->setTotalUsed($clientService->getTotalUsed() + 1);
        $clientService->save();
    }

    public function getClientServices(Client $client, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model
            ->with(['service', 'createdBy', 'updatedBy'])
            ->where('client_id', '=', $client->getId())
            ->paginate(30, ['*'], null, $pageNumber);
    }

    public function updateClientService(
        ClientService $clientService,
        UpdateClientServiceResource $resource
    ): ClientService {
        $clientService->setExtras($resource->getExtras())
            ->setUpdatedBy($resource->getUpdatedBy())
            ->setMarketingQuota($resource->getMarketingQuota())
            ->setExtraQuota($resource->getExtraQuota())
            ->markAsEnabled($resource->isEnabled());

        $clientService->save();

        return $clientService;
    }

    public function updateClientsExtrasByService(Service $service): void
    {
        $this->model->where('service_id', $service->getId())->update([
            'extras' => $service->getExtras(),
        ]);
    }
}
