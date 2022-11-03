<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Enum\ServicesEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Users\UserResource;
use App\Models\Client;
use App\Models\Users\Interfaces\UserTypeInterface;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class AllowedMentionUsersListController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        DepartmentRepositoryInterface $departmentRepository,
    ) {
        $this->clientRepository = $clientRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.'
            ]);
        }

        $department = $this->departmentRepository->findByName(ServicesEnum::SOCIAL_MEDIA);

        $userTypes = [
            ...$department->getAdminUsers(),
            ...$client->getClientUsers(),
        ];

        $users = [];

        /** @var UserTypeInterface $userType */
        foreach ($userTypes as $userType) {
            if ($userType->getUser() === null) {
                continue;
            }

            $users[] = new UserResource($userType->getUser());
        }

        return new JsonResource($users);
    }
}
