<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\Tickets\Validations\Rules;

use App\Models\ClientService;
use App\Models\Service;
use App\Services\Tickets\Interfaces\Validations\TicketEventServiceValidationRuleInterface;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketEventServiceValidationRuleStub extends AbstractStub implements TicketEventServiceValidationRuleInterface
{
    /**
     * @throws \Throwable
     */
    public function validate(ClientService $clientService, Service $service, array $extras = []): bool
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
