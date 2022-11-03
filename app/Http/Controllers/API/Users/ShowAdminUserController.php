<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Users\UserResource;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ShowAdminUserController extends AbstractAPIController
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if ($user === null) {
            return $this->respondNotFound(['message' => 'User not found.']);
        }

        if ($user->getUserType() instanceof AdminUser === false) {
            return $this->respondNotFound(['message' => 'User not found.']);
        }

        return new UserResource($user);
    }
}
