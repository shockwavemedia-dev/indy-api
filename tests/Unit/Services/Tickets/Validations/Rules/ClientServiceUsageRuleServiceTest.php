<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Tickets\Validations\Rules;

use App\Enum\ServicesEnum;
use App\Models\ClientService;
use App\Models\Service;
use App\Services\Tickets\Exceptions\ServiceUsageQuotaLimitException;
use App\Services\Tickets\Validations\Rules\ClientServiceUsageRuleService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Services\Tickets\Validations\Rules\ClientServiceUsageRuleService
 */
final class ClientServiceUsageRuleServiceTest extends TestCase
{
    /**
     * @throws ServiceUsageQuotaLimitException
     */
    public function testValidateSuccess(): void
    {
        $service = new Service();

        $clientService = new ClientService();
        $clientService->setMarketingQuota(0);

        $rule = new ClientServiceUsageRuleService();

        $result = $rule->validate($clientService, $service, []);

        $this->assertTrue($result);
    }

    /**
     * @throws ServiceUsageQuotaLimitException
     */
    public function testValidateThrowException(): void
    {
        $service = new Service();
        $service->setAttribute('name', ServicesEnum::GRAPHIC_DESIGN);

        $clientService = new ClientService();
        $clientService->setMarketingQuota(1);
        $clientService->setTotalUsed(1);

        $rule = new ClientServiceUsageRuleService();

        $this->expectException(ServiceUsageQuotaLimitException::class);

        $rule->validate($clientService, $service, []);
    }
}
