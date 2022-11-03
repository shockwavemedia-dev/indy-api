<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;


use App\Enum\UserStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class RevokeUserController extends AbstractAPIController
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
            return $this->respondNoContent();
        }

        try {
            $this->userRepository->revoke($user);

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            return $this->respondNoContent();
        }
    }
}
