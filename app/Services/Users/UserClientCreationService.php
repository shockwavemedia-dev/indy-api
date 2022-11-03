<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Enum\UserTypeEnum;
use App\Models\Users\ClientUser;
use App\Repositories\Interfaces\ClientUserRepositoryInterface;
use App\Services\Users\Interfaces\UserTypeFactoryInterface;
use App\Services\Users\Resources\CreateClientUserResource;
use App\Services\Users\Interfaces\CreateUserTypeResourceInterface;

final class UserClientCreationService implements UserTypeFactoryInterface
{
    private ClientUserRepositoryInterface $repository;

    public function __construct(ClientUserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function create(CreateClientUserResource|CreateUserTypeResourceInterface $resource): ClientUser
    {
        /** @var ClientUser $clientUser */
        $clientUser = $this->repository->create([
           'client_id' => $resource->getClient()->getId(),
           'client_role' => $resource->getRole()
        ]);

        return $clientUser;
    }

    public function supports(UserTypeEnum $userType): bool
    {
        return $userType->getValue() === UserTypeEnum::CLIENT;
    }
}
