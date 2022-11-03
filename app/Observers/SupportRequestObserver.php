<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enum\EmailStatusEnum;
use App\Jobs\SupportRequests\DepartmentManagerSlackNotificationJob;
use App\Models\SupportRequest;
use App\Models\Users\AdminUser;
use App\Notifications\SupportRequestAccountManagerEmail;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;

final class SupportRequestObserver
{
    private AdminUserRepositoryInterface $adminUserRepository;

    private EmailLogFactoryInterface $emailLogFactory;

    public function __construct(
        AdminUserRepositoryInterface $adminUserRepository,
        EmailLogFactoryInterface $emailLogFactory
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->emailLogFactory = $emailLogFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function created(SupportRequest $supportRequest): void
    {
        $adminUsers = $this->adminUserRepository->findAccountManagersByDepartment($supportRequest->getDepartment());

        /** @var AdminUser $adminUser */
        foreach ($adminUsers as $adminUser) {
            $emailLog = $this->emailLogFactory->make(new CreateEmailLogResource([
                'emailType' => $supportRequest,
                'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
                'to' => $adminUser->getUser()->getEmail(),
                'message' => 'Ticket Email', // Static message, real email is in json format
            ]));

            $adminUser->getUser()->sendEmailForSupportRequest($emailLog, $supportRequest);

            DepartmentManagerSlackNotificationJob::dispatch($supportRequest, $adminUser->getUser());
        }
    }
}
