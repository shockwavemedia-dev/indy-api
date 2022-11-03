<?php

declare(strict_types=1);

namespace App\Services\Users\Resolvers;

use App\Enum\EmailStatusEnum;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use App\Services\Users\Interfaces\UserResetPasswordResolverInterface;
use Exception;
use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use function sprintf;

final class UserResetPasswordResolver implements UserResetPasswordResolverInterface
{
    private EmailLogFactoryInterface $emailLogFactory;

    private Repository $configRepository;

    public function __construct(
        EmailLogFactoryInterface $emailLogFactory,
        Repository $repository
    ) {
        $this->configRepository = $repository;
        $this->emailLogFactory = $emailLogFactory;
    }

    /**
     * @throws Exception
     */
    public function resolve(User $user, string $token): void
    {
        $config = $this->configRepository->get('mail');

        $url = Arr::get($config, 'client_url');

        if ($url === null) {
            throw new Exception('Url in resetting password is empty');
        }

        $url = sprintf('%s/auth/password-reset',$url);

        $emailLog = $this->emailLogFactory->make(new CreateEmailLogResource([
            'emailType' => $user,
            'message' => 'System generated, resetting email password',
            'to' => $user->getEmail(),
            'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
        ]));

        $user->notify((new ResetPasswordNotification($emailLog, $url, $token)));
    }
}
