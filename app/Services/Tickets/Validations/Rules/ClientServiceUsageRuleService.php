<?php

declare(strict_types=1);

namespace App\Services\Tickets\Validations\Rules;

use App\Models\ClientService;
use App\Models\Service;
use App\Services\Tickets\Exceptions\ServiceUsageQuotaLimitException;
use App\Services\Tickets\Interfaces\Validations\TicketEventServiceValidationRuleInterface;

final class ClientServiceUsageRuleService implements TicketEventServiceValidationRuleInterface
{
    /**
     * @throws \App\Services\Tickets\Exceptions\ServiceUsageQuotaLimitException
     */
    public function validate(ClientService $clientService, Service $service, array $extras = []): bool
    {
        // Service is not infinite, if total used already reached the quota throw exception
        if (
            $clientService->getMarketingQuota() > 0 &&
            ($clientService->getMarketingQuota() + $clientService->getExtraQuota()) <= $clientService->getTotalUsed()
        ) {
            throw new ServiceUsageQuotaLimitException(
                \sprintf(
                    'Service %s already reached its quota.',
                    $service->getName()
                )
            );
        }

        return true;
    }
}
