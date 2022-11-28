<?php

declare(strict_types=1);

namespace Tests\Functional\Http\Controllers\API\Users;

use Tests\Functional\Http\Controllers\API\AbstractAPITestCase;

/**
 * @covers \App\Http\Controllers\API\Users\CreateAdminUserController
 */
final class CreateAdminUserControllerTest extends AbstractAPITestCase
{
    public function testCreateUserAdminSuccess(): void
    {
        $user = $this->env->user([
            'email' => 'test@testmail.com',
        ])->user;

        $this->env->department();

        $this->setHeadersToken($user);

        $data = <<<'JSON'
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
            "user_type" : "admin_users",
            "role" : "admin",
            "departments" : [1]
        }
        JSON;

        $response = $this->post('/api/v1/users/admin', json_decode($data, true));

        $arrayResponse = $this->toArrayResponse($response);

        $this->assertEquals(200, $response->getStatusCode());
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

    public function testCreateUserAdminUsingClientToken(): void
    {
        $clientUser = $this->env->clientUser()->clientUser;

        $user = $this->env->user([
            'morphable_id' => $clientUser->getId(),
            'morphable_type' => \get_class($clientUser),
            'email' => 'test@testmail.com',
        ])->user;

        $this->setHeadersToken($user);

        $data = <<<'JSON'
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
            "user_type" : "admin_users",
            "role" : "admin"
        }
        JSON;

        $response = $this->post('/api/v1/users/admin', json_decode($data, true));

        $arrayResponse = $this->toArrayResponse($response);

        self::assertEquals(
            [
                'status' => 'User has no permission for this module',
            ],
            $arrayResponse
        );
    }
}
