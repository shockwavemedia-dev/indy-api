<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Users;

use App\Enum\UserStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Users\ForgotPasswordRequest;
use App\Notifications\UserEmailVerification;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Users\Interfaces\UserEmailVerificationResolverInterface;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ResentEmailVerificationController extends AbstractAPIController
{
    private UserEmailVerificationResolverInterface $userEmailVerificationResolver;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserEmailVerificationResolverInterface $userEmailVerificationResolver,
        UserRepositoryInterface $userRepository
    ) {
        $this->userEmailVerificationResolver = $userEmailVerificationResolver;
        $this->userRepository = $userRepository;
    }

    public function __invoke(ForgotPasswordRequest $request): JsonResource
    {
        $user = $this->userRepository->findByEmail($request->getEmail());

        if ($user === null) {
            return $this->respondNotFound([
                'message' => 'Email not found.',
            ]);
        }

        if ($user->getStatus()->getValue() !== UserStatusEnum::INVITED) {
            return $this->respondBadRequest([
                'message' => 'Cannot send email verification with this email, please contact System Administrator.',
            ]);
        }

        try {
            $this->userEmailVerificationResolver->resolve($user);

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
