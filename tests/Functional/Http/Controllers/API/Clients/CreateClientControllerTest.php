<?php

declare(strict_types=1);

namespace Tests\Functional\Http\Controllers\API\Clients;

use App\Enum\AdminRoleEnum;
use Tests\Functional\Http\Controllers\API\AbstractAPITestCase;

/**
 * @covers \App\Http\Controllers\API\Clients\CreateClientController
 */
final class CreateClientControllerTest extends AbstractAPITestCase
{
    public function testCreateClientSuccess(): void
    {
        $adminUser = $this->env->adminUser([
            'admin_role' => AdminRoleEnum::ADMIN,
        ])->adminUser;

        $user = $this->env->user([
            'email' => 'test@testmail.com',
            'morphable_id' => $adminUser->getId(),
            'morphable_type' => \get_class($adminUser),
        ])->user;

        $this->setHeadersToken($user);

        $data = <<<'JSON'
        {
            "name": "Test Client 1",
            "client_code": "TC1",
            "logo": "testlogo1",
            "address": "13 Clyde St, Batemans Bay NSW 2536",
            "phone": "(02) 1234 5678",
            "timezone": "(UTC+10:00) Canberra, Melbourne, Sydney",
            "client_since": "2021-01-01",
            "overview": "123",
            "rating": "5",
            "status": "active"
        }
        JSON;

        $response = $this->post('/api/v1/clients', json_decode($data, true));

        $arrayResponse = $this->toArrayResponse($response);

        $this->assertArrayHasKeys(
            [
                'id',
                'name',
                'client_code',
                'logo',
                'address',
                'phone',
                'timezone',
                'client_since',
                'main_client_id',
                'overview',
                'rating',
                'status',
            ],
            $arrayResponse
        );
    }

    public function testCreateClientThrowException(): void
    {
        $adminUser = $this->env->adminUser([
            'admin_role' => AdminRoleEnum::ADMIN,
        ])->adminUser;

        $user = $this->env->user([
            'email' => 'test@testmail.com',
            'morphable_id' => $adminUser->getId(),
            'morphable_type' => \get_class($adminUser),
        ])->user;

        $client = $this->env->client()->client;

        $existingClient = $client->getName();
        $existingCode = $client->getClientCode();

        $this->setHeadersToken($user);

        $data = <<<JSON
        {
            "name": "$existingClient",
            "client_code": "$existingCode",
            "logo": "testlogo1",
            "address": "13 Clyde St, Batemans Bay NSW 2536",
            "phone": "(02) 1234 5678",
            "timezone": "(UTC+10:00) Canberra, Melbourne, Sydney",
            "client_since": "2021-01-01",
            "overview": "123",
            "rating": "5",
            "status": "active",
            "main_client_id": 999
        }
        JSON;

        $expected =
            [
                'name' => ['The name has already been taken.'],
                'client_code' => ['The client code has already been taken.'],
                'main_client_id' => ['The selected main client id is invalid.'],
            ];

        $response = $this->post('/api/v1/clients', json_decode($data, true));

        $arrayResponse = $this->toArrayResponse($response);

        $this->assertEquals($expected, $arrayResponse);
    }
}
