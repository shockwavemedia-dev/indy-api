<?php

declare(strict_types=1);

namespace App\Services\Users\Resolvers;

use App\Enum\EmailStatusEnum;
use App\Models\User;
use App\Notifications\UserEmailVerification;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use App\Services\Users\Interfaces\UserEmailVerificationResolverInterface;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;

final class UserEmailVerificationResolver implements UserEmailVerificationResolverInterface
{
    private EmailLogFactoryInterface $emailLogFactory;

    private TokenRepositoryInterface $tokenRepository;

    public function __construct(
        EmailLogFactoryInterface $emailLogFactory,
        TokenRepositoryInterface $tokenRepository
    ) {
        $this->emailLogFactory = $emailLogFactory;
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(User $user): void
    {
        $token = $this->tokenRepository->create($user);

        $emailLog = $this->emailLogFactory->make(new CreateEmailLogResource([
            'emailType' => $user,
            'message' => 'System generated, email verification',
            'to' => $user->getEmail(),
            'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
        ]));

        $user->notify(new UserEmailVerification($emailLog, $token));
    }
}
