<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Users\ForgotPasswordRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Users\Interfaces\UserResetPasswordResolverInterface;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ForgotPasswordController extends AbstractAPIController
{
    private TokenRepositoryInterface $tokenRepository;

    private UserRepositoryInterface $userRepository;

    private UserResetPasswordResolverInterface $userResetPasswordResolver;

    public function __construct(
        UserResetPasswordResolverInterface $userResetPasswordResolver,
        UserRepositoryInterface $userRepository,
        TokenRepositoryInterface $tokenRepository
    ) {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
        $this->userResetPasswordResolver = $userResetPasswordResolver;
    }

    public function __invoke(ForgotPasswordRequest $request): JsonResource
    {
        $user = $this->userRepository->findByEmail($request->getEmail());

        if ($user === null) {
            return $this->respondNotFound([
                'message' => 'Email not found.',
            ]);
        }

        try {
            $token = $this->tokenRepository->create($user);
            $this->userResetPasswordResolver->resolve($user, $token);

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
