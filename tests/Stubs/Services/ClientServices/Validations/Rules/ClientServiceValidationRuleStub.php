<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\ClientServices\Validations\Rules;

use App\Models\ClientService;
use App\Models\Service;
use App\Services\ClientServices\Interfaces\Validations\ClientServiceValidationRuleInterface;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class ClientServiceValidationRuleStub extends AbstractStub implements ClientServiceValidationRuleInterface
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
