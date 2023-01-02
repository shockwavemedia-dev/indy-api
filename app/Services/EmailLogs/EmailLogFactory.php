<?php

declare(strict_types=1);

namespace App\Services\EmailLogs;

use App\Models\Emails\EmailLog;
use App\Repositories\Interfaces\EmailLogRepositoryInterface;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;

final class EmailLogFactory implements EmailLogFactoryInterface
{
    private EmailLogRepositoryInterface $emailLogRepository;

    public function __construct(EmailLogRepositoryInterface $emailLogRepository)
    {
        $this->emailLogRepository = $emailLogRepository;
    }

    public function make(CreateEmailLogResource $resource): EmailLog
    {
        /** @var EmailLog $emailLog */
        $emailLog = $this->emailLogRepository->create([
            'status' => $resource->getStatus()->getValue(),
            'failed_details' => $resource->getFailedDetails(),
            'cc' => $resource->getCc(),
            'message' => $resource->getMessage(),
            'to' => $resource->getTo(),
            'morphable_id' => $resource->getEmailType()->getId(),
            'morphable_type' => \get_class($resource->getEmailType()),
        ]);

        return $emailLog;
    }
}
