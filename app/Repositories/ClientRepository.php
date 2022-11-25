<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\ClientStatusEnum;
use App\Models\Client;
use App\Models\ClientService;
use App\Models\Users\ClientUser;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\Clients\Resources\UpdateClientResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final class ClientRepository extends BaseRepository implements ClientRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Client());
    }

    public function update(Client $client, UpdateClientResource $resource): Client
    {
        $client->setName($resource->getName())
            ->setClientCode($resource->getClientCode())
            ->setLogoFileId($resource->getLogoFileId())
            ->setAddress($resource->getAddress())
            ->setPhone($resource->getPhone())
            ->setTimezone($resource->getTimezone())
            ->setClientSince($resource->getClientSince())
            ->setMainClientId($resource->getMainClientId())
            ->setOverview($resource->getOverview())
            ->setRating($resource->getRating())
            ->setStatus($resource->getStatus())
            ->setDesignatedDesignerId($resource->getDesignatedDesignerId())
            ->setDesignatedAnimatorId($resource->getDesignatedAnimatorId())
            ->setDesignatedPrinterManagerId($resource->getDesignatedPrinterManagerId())
            ->setDesignatedWebEditorId($resource->getDesignatedWebEditorId())
            ->setDesignatedSocialMediaManagerId($resource->getDesignatedSocialMediaManagerId())
            ->setStyleGuide($resource->getStyleGuide())
            ->setNote($resource->getNote());

        if ($resource->getPrinterId() > 0) {
            $client->setPrinterId($resource->getPrinterId());
        }

        $client->save();

        return $client;
    }

    public function findAllClient(
        ?int $size = null,
        ?int $pageNumber = null,
        ?string $sortBy = null,
        ?string $sortOrder = null
    ): LengthAwarePaginator {

        if ($sortBy === null) {
            return $this->model
                ->with(['clientScreens.screen', 'printer', 'logo', 'designatedDesigner'])
                ->orderBy('created_at', 'desc')
                ->paginate($size, ['*'], null, $pageNumber);
        }

        return $this->model
            ->with(['clientScreens.screen', 'printer', 'logo', 'designatedDesigner'])
            ->orderBy($sortBy, $sortOrder)
            ->paginate($size, ['*'], null, $pageNumber);

    }

    public function deleteClient(Client $client): void
    {
        $client->delete();
        $client->setStatus(new ClientStatusEnum(ClientStatusEnum::DELETED));
        $client->save();
    }

    public function updateClientOwner(Client $client, ClientUser $clientUser): Client
    {
        $client->setOwnerId($clientUser->getId());

        $client->save();

        return $client;
    }

    public function findAll(): Collection
    {
        return $this->model->get();
    }
}
