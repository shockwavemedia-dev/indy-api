<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class DeleteUserController extends AbstractAPIController
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
            $this->userRepository->deleteUser($user);

            return $this->respondNoContent();
            // @codeCoverageIgnoreStart
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        // @codeCoverageIgnoreEnd
    }
}
