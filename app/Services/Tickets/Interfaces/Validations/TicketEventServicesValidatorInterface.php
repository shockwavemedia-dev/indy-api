<?php

declare(strict_types=1);

namespace App\Services\Tickets\Interfaces\Validations;

use App\Models\Client;

interface TicketEventServicesValidatorInterface
{
    /**
     * @throws \App\Services\Tickets\Exceptions\TicketEventServiceRuleException
     */
    public function validate(Client $client, array $services): bool;
}
