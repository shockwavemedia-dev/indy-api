<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Client;
use App\Models\Users\ClientUser;
use App\Services\Clients\Resources\UpdateClientResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ClientRepositoryInterface
{
    public function findAll(): Collection;

    public function update(Client $client, UpdateClientResource $resource): Client;

    public function findAllClient(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function deleteClient(Client $client): void;

    public function updateClientOwner(Client $client, ClientUser $clientUser): Client;

}
