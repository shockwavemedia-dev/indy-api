<?php

declare(strict_types=1);

namespace Tests\Functional\Http\Controllers\API;

use App\Enum\UserStatusEnum;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\API\Authentication\LoginController
 * @
 */
final class LoginControllerTest extends AbstractAPITestCase
{
    public function testLoginSuccess(): void
    {
        $user = $this->env->user([
            'email' => 'test@testmail.com'
        ])->user;

        $response = $this->post(
            '/api/authenticate',
            [
                'email' => $user->getEmail(),
                'password' => 'superadmin',
            ]
        );

        $arrayResponse = $this->toArrayResponse($response);

        $this->assertArrayHasKeys(
            [
                'access_token',
                'token_type',
                'expires_in',
                'refresh_token',
                'user',
            ],
            $arrayResponse
        );
    }

    public function testLoginInvalidEmail(): void
    {
        $response = $this->post(
            '/api/authenticate',
            [
                'email' => 'test23@testmail.com',
                'password' => 'superadmin',
            ]
        );

        $response->assertExactJson([
            "data" => [
                "status" => 401,
                "title" => "Unauthorized",
                "message" => "Invalid credentials",
            ]
        ]);
    }

    public function testLoginInvalidPassword(): void
    {
        $user = $this->env->user([
            'email' => 'test@testmail.com'
        ])->user;

        $response = $this->post(
            '/api/authenticate',
            [
                'email' => $user->getEmail(),
                'password' => 'incorrect-password',
            ]
        );

        $response->assertExactJson([
            "data" => [
                "status" => 401,
                "title" => "Unauthorized",
                "message" => "The user credentials were incorrect.",
            ]
        ]);
    }

    public function testLoginNotActiveStatus(): void
    {
        $user = $this->env->user([
            'email' => 'test@testmail.com',
            'status' => UserStatusEnum::INACTIVE,
        ])->user;

        $response = $this->post(
            '/api/authenticate',
            [
                'email' => $user->getEmail(),
                'password' => 'superadmin',
            ]
        );

        $response->assertExactJson([
            "data" => [
                "status" => 401,
                "title" => "Unauthorized",
                "message" => "User is not active.",
            ]
        ]);
    }
}
