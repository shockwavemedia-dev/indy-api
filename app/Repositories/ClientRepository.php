<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\ClientStatusEnum;
use App\Enum\ServicesEnum;
use App\Models\Client;
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
        ?string $sortOrder = null,
        ?string $name = null
    ): LengthAwarePaginator {
        return $this->model
            ->when($sortBy, function ($query) use ($sortBy, $sortOrder) {
                $query->orderBy($sortBy, $sortOrder);
            })
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'LIKE', '%'.$name.'%');
            })
            ->with(['clientScreens.screen', 'printer', 'logo', 'designatedDesigner'])
            ->orderBy('name', 'asc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findAllClientWithSocialMediaService(
        ?int $size = null,
        ?int $pageNumber = null,
        ?string $sortBy = null,
        ?string $sortOrder = null
    ): LengthAwarePaginator {
        return $this->model
            ->whereHas('clientServices', function ($query) {
                $query->whereHas('service', function ($query) {
                    $query->where('name', ServicesEnum::SOCIAL_MEDIA);
                });

                $query->where('is_enabled', 1);
            })
            ->with(['clientScreens.screen', 'printer', 'logo', 'designatedDesigner'])
            ->orderBy('name', 'asc')
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

    public function findByCode(string $code): ?Client
    {
        return $this->model->where('client_code', $code)->first();
    }
}
