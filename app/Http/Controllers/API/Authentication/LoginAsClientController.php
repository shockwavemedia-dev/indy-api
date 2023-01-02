<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Authentication;

use App\Enum\UserStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Users\UserResource;
use App\Repositories\Interfaces\ClientUserRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

final class LoginAsClientController extends AbstractAPIController
{
    /**
     * @var string[]
     */
    private const NOT_ALLOWED_STATUS = [
        UserStatusEnum::INACTIVE,
        UserStatusEnum::REVOKED,
        UserStatusEnum::DELETED,
    ];

    private UserRepositoryInterface $userRepository;

    private ClientUserRepositoryInterface $clientUserRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ClientUserRepositoryInterface $clientUserRepository
    ) {
        $this->userRepository = $userRepository;
        $this->clientUserRepository = $clientUserRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var \App\Models\Users\ClientUser $clientUser */
        $clientUser = $this->clientUserRepository->find($id);

        if ($clientUser === null) {
            return $this->respondNotFound([
                'message' => 'User not found.',
            ]);
        }

        try {
            $user = $this->userRepository->findByClientUser($clientUser);

            if ($user === null) {
                return $this->respondNotFound([
                    'message' => 'User not found.',
                ]);
            }

            if (\in_array($user->getStatus()->getValue(), self::NOT_ALLOWED_STATUS, true) === true) {
                return $this->respondUnauthorised([
                    'message' => 'User is not active.',
                ]);
            }

            $token = $user->createToken('Logged in as client')->accessToken;

            return new JsonResource([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => 3600,
                'user' => new UserResource($user),
            ]);
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            return $this->respondInternalError([
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
            // @codeCoverageIgnoreEnd
        }
    }
}
