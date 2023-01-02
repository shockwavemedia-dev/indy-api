<?php

declare(strict_types=1);

namespace App\Services\Tickets\Interfaces\Validations;

use App\Models\ClientService;
use App\Models\Service;

interface TicketEventServiceValidationRuleInterface
{
    /**
     * @throws \App\Services\Tickets\Exceptions\TicketEventServiceRuleException
     */
    public function validate(ClientService $clientService, Service $service, array $extras = []): bool;
}
