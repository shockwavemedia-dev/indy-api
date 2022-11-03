<?php

declare(strict_types=1);

 namespace Tests\Unit\Models;

 use App\Enum\ClientRoleEnum;
 use App\Models\Users\ClientUser;
 use PHPUnit\Framework\TestCase;

 /**
  * @covers \App\Models\Users\ClientUser
  */
 final class ClientUserTest extends TestCase
 {
     public function testGetterAndSetters(): void
    {

        $expected = [
            'id' => 1,
            'client_id' => 1,
            'client_role' => ClientRoleEnum::MARKETING,
        ];

        $clientUser = new ClientUser();
        $clientUser->setAttribute('id', 1);
        $clientUser->setAttribute('client_id', 1);
        $clientUser->setRole(ClientRoleEnum::MARKETING);

        $actual = [
            'id' => $clientUser->getId(),
            'client_id' => $clientUser->getClientId(),
            'client_role' => $clientUser->getRole(),
        ];

        self::assertEquals($expected, $actual);
    }
 }
