<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ClientServices;

use App\Enum\ServiceExtraEnum;
use App\Enum\ServicesEnum;
use App\Models\Client;
use App\Models\ClientService;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Services\ClientServices\ClientServiceUpdate;
use App\Services\ClientServices\Resources\UpdateClientServiceResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\ClientServiceRepositoryStub;

/**
 * @covers \App\Services\ClientServices\ClientServiceUpdate
 */
final class ClientServiceUpdateTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testUpdateClientServicesSuccess(): void
    {
        $adminUser = new AdminUser();
        $user = new User();
        $user->setRelation('userType', $adminUser);
        $user->setAttribute('id', 1);

        $client = new Client();
        $client->setAttribute('client_code', 'test');
        $client->setAttribute('id', 1);

        $clientServiceCollection = new Collection();
        $clientService1 = new ClientService();
        $clientService1->setAttribute('service_id', 1);
        $clientService2 = new ClientService();
        $clientService2->setAttribute('service_id', 2);

        $clientServiceCollection->add($clientService1);
        $clientServiceCollection->add($clientService2);

        $client->setRelation('clientServices', $clientServiceCollection);
        $client->setAttribute('client_code', 'test');
        $client->setAttribute('id', 1);

        $clientServiceRepository = new ClientServiceRepositoryStub([
            'updateClientService' => $clientService1,
            'updateClientService' => $clientService2,
        ]);

        $services = [
            [
                'service_id' => 1,
                'extras' => Arr::get(ServiceExtraEnum::EXTRAS, ServicesEnum::GRAPHIC_DESIGN, []),
                'marketing_quota' => 0,
                'extra_quota' => 0,
                'is_enabled' => true,
            ],
            [
                'service_id' => 2,
                'extras' => Arr::get(ServiceExtraEnum::EXTRAS, ServicesEnum::ADVERTISING, []),
                'marketing_quota' => 0,
                'extra_quota' => 0,
                'is_enabled' => true,
            ],
        ];

        $resolver = new ClientServiceUpdate(
            $clientServiceRepository,
        );

        $expectedCall = [
            [
                'updateClientService' => [
                    $clientService1,
                    new UpdateClientServiceResource([
                        'clientId' => 1,
                        'serviceId' => 1,
                        'extras' => Arr::get(ServiceExtraEnum::EXTRAS, ServicesEnum::GRAPHIC_DESIGN, []),
                        'updatedBy' => 1,
                        'marketingQuota' => 0,
                        'extraQuota' => 0,
                        'isEnabled' => true,
                    ]),
                ],
            ],
            [
                'updateClientService' => [
                    $clientService2,
                    new UpdateClientServiceResource([
                        'clientId' => 1,
                        'serviceId' => 2,
                        'extras' => Arr::get(ServiceExtraEnum::EXTRAS, ServicesEnum::ADVERTISING, []),
                        'updatedBy' => 1,
                        'marketingQuota' => 0,
                        'extraQuota' => 0,
                        'isEnabled' => true,
                    ]),
                ],
            ],
        ];

        $resolver->update($client, $user, $services);

        $this->assertEquals($expectedCall, $clientServiceRepository->getCalls());
    }
}
