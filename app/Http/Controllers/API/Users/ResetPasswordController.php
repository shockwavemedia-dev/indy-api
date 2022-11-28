<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Users\ResetPasswordRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ResetPasswordController extends AbstractAPIController
{
    private Hasher $hasher;

    private TokenRepositoryInterface $tokenRepository;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        TokenRepositoryInterface $tokenRepository,
        Hasher $hasher
    ) {
        $this->hasher = $hasher;
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(ResetPasswordRequest $request): JsonResource
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

            $password = $this->hasher->make($request->getPassword());

            $this->userRepository->updatePassword($user, $password);

            $this->tokenRepository->delete($user);

            return $this->respondOk([
                'message' => 'Password successfully changed.',
            ]);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
