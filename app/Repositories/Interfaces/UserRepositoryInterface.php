<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Client;
use App\Models\User;
use App\Models\Users\ClientUser;
use App\Services\Users\Resources\UpdateUserResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function deleteUser(User $user): void;

    public function findAllAdminUsers(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function findAllClientUsersByClient(Client $client, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function findByIds(array $ids): ?Collection;

    public function findByEmail(string $email): ?User;

    public function revoke(User $user): void;

    public function update(User $user, UpdateUserResource $resource): User;

    public function updatePassword(User $user, string $password): void;

    public function verifyUser(User $user): void;

    public function findByClientUser(ClientUser $clientUser): ?User;
}
