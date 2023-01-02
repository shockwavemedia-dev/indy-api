<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Tickets\Validations\Rules;

use App\Enum\ServicesEnum;
use App\Models\ClientService;
use App\Models\Service;
use App\Services\Tickets\Exceptions\DisabledServiceException;
use App\Services\Tickets\Validations\Rules\ClientServiceEnableRuleService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Services\Tickets\Validations\Rules\ClientServiceEnableRuleService
 */
final class ClientServiceEnableRuleServiceTest extends TestCase
{
    /**
     * @throws DisabledServiceException
     */
    public function testValidateSuccess(): void
    {
        $service = new Service();

        $clientService = new ClientService();
        $clientService->markAsEnabled(true);

        $rule = new ClientServiceEnableRuleService();

        $result = $rule->validate($clientService, $service, []);

        $this->assertTrue($result);
    }

    /**
     * @throws DisabledServiceException
     */
    public function testValidateThrowException(): void
    {
        $service = new Service();
        $service->setAttribute('name', ServicesEnum::GRAPHIC_DESIGN);

        $clientService = new ClientService();
        $clientService->markAsEnabled(false);

        $rule = new ClientServiceEnableRuleService();

        $this->expectException(DisabledServiceException::class);

        $rule->validate($clientService, $service, []);
    }
}
