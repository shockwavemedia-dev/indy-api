<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\ClientService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\ClientService
 */
final class ClientServiceTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $expected = [
            'id' => 1,
            'client_id' => 1,
            'service_id' => 1,
            'marketing_quota' => null,
            'extra_quota' => null,
            'total_used' => null,
            'is_enable' => false,
            'created_by' => 1,
            'updated_by' => 1,
        ];

        $clientService = new ClientService();
        $clientService->setAttribute('id', 1);
        $clientService->setAttribute('client_id', 1);
        $clientService->setAttribute('service_id', 1);
        $clientService->setMarketingQuota();
        $clientService->setExtraQuota();
        $clientService->setTotalUsed();
        $clientService->markAsEnabled(false);
        $clientService->setAttribute('created_by', 1);
        $clientService->setAttribute('updated_by', 1);

        $actual = [
            'id' => $clientService->getId(),
            'client_id' => $clientService->getClientId(),
            'service_id' => $clientService->getServiceId(),
            'marketing_quota' => $clientService->getMarketingQuota(),
            'extra_quota' => $clientService->getExtraQuota(),
            'total_used' => $clientService->getTotalUsed(),
            'is_enable' => $clientService->isEnabled(),
            'created_by' => $clientService->getCreatedById(),
            'updated_by' => $clientService->getUpdatedById(),
        ];

        self::assertEquals($expected, $actual);
    }
}
