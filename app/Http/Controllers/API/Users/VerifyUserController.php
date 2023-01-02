<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Users\VerifyUserRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class VerifyUserController extends AbstractAPIController
{
    private TokenRepositoryInterface $tokenRepository;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        TokenRepositoryInterface $tokenRepository
    ) {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(VerifyUserRequest $request): JsonResource
    {
        $user = $this->userRepository->findByEmail($request->getEmail());

        if ($user === null) {
            return $this->respondNotFound([
                'message' => 'Email not found.',
            ]);
        }

        try {
            $exist = $this->tokenRepository->exists($user, $request->getToken());

            if ($exist === false) {
                return $this->respondBadRequest([
                    'message' => 'Invalid token.',
                ]);
            }

            $this->userRepository->verifyUser($user);

//            $this->tokenRepository->delete($user);

            return $this->respondOk([
                'message' => 'Valid token',
            ]);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
