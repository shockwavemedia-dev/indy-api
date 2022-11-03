<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Users\NewUserSetPasswordRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Throwable;

final class NewUserSetPasswordController extends AbstractAPIController
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

    public function __invoke(NewUserSetPasswordRequest $request):  JsonResource
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

            $user->setPassword(Hash::make($request->getPassword()));

            $user->save();

            $this->tokenRepository->delete($user);

            return $this->respondOk([
                'message' => 'Password set.'
            ]);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
