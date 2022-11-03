<?php

declare(strict_types=1);

namespace Tests\Functional\Http\Controllers\API\Users;

use App\Enum\AdminRoleEnum;
use App\Models\Client;
use Tests\Functional\Http\Controllers\API\AbstractAPITestCase;

/**
 * @covers \App\Http\Controllers\API\Users\CreateClientUserController
 */
final class CreateClientUserControllerTest extends AbstractAPITestCase
{
    public function testCreateUserClientSuccess(): void
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

        $this->setHeadersToken($user);

        $clientId = $client->getId();

        $data =  <<<JSON
        {
            "email" : "markf23sd4sss3s@dailypress.com",
            "password" : "letmein",
            "birth_date" : "1993/02/02",
            "password_confirmation": "letmein",
            "contact_number" : "123",
            "first_name" : "123",
            "last_name" : "123",
            "middle_name" : "123",
            "gender" : "Male",
            "user_type" : "client",
            "role" : "marketing_manager",
            "client_id" : $clientId
        }
        JSON;

        $response = $this->post('/api/v1/users/client', json_decode($data, true));

        $arrayResponse = $this->toArrayResponse($response);

        $this->assertArrayHasKeys(
            [
                'email',
                'status',
                'first_name',
                'middle_name',
                'last_name',
                'contact_number',
                'gender',
                'birth_date',
                'user_type',
            ],
            $arrayResponse
        );
    }
}
