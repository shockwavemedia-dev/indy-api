<?php

declare(strict_types=1);

namespace Tests\Functional\Http\Controllers\API\Users;

use App\Enum\UserStatusEnum;
use Illuminate\Http\Response;
use Tests\Functional\Http\Controllers\API\AbstractAPITestCase;

/**
 * @covers \App\Http\Controllers\API\Users\DeleteUserController
 */
final class DeleteUserControllerTest extends AbstractAPITestCase
{
    public function testDeleteInvalidId(): void
    {
        $user = $this->env->user()->user;

        $this->env->department();

        $this->setHeadersToken($user);

        $response = $this->delete('/api/v1/users/-10');

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testDeleteSuccess(): void
    {
        $user = $this->env->user()->user;

        $this->env->department();

        $this->setHeadersToken($user);

        $userToBeDeleted = $this->env->user()->user;

        $expected = [
            'code' => Response::HTTP_OK,
            'status' => UserStatusEnum::DELETED,
        ];

        $response = $this->delete(\sprintf('/api/v1/users/%s', $userToBeDeleted->getId()));

        $actual = [
            'code' => $response->getStatusCode(),
            'status' => $userToBeDeleted->refresh()->getStatus()->getValue(),
        ];

        self::assertEquals($expected, $actual);
    }
}
