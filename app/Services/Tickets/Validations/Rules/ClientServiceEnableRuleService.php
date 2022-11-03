<?php

declare(strict_types=1);

namespace App\Services\Tickets\Validations\Rules;

use App\Models\ClientService;
use App\Models\Service;
use App\Services\Tickets\Exceptions\DisabledServiceException;
use App\Services\Tickets\Interfaces\Validations\TicketEventServiceValidationRuleInterface;

final class ClientServiceEnableRuleService implements TicketEventServiceValidationRuleInterface
{
    /**
     * @throws \App\Services\Tickets\Exceptions\DisabledServiceException
     */
    public function validate(ClientService $clientService, Service $service, array $extras = []): bool
    {
        if ($clientService->isEnabled() === true) {
            return true;
        }

        throw new DisabledServiceException(
            \sprintf(
                'Service %s not enabled.',
                $service->getName()
            )
        );
    }
}
