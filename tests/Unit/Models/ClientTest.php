<?php

declare(strict_types=1);

 namespace Tests\Unit\Models;

 use App\Enum\ClientStatusEnum;
 use App\Models\Client;
 use PHPUnit\Framework\TestCase;

 /**
  * @covers \App\Models\Client
  */
 final class ClientTest extends TestCase
 {
     public function testGetterAndSetters(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'Test Company Demo',
            'client_code' => 'TCP',
            'address' => '123 Clyde St, Batemans Bay NSW 2536',
            'phone' => '(02) 4472 9131',
            'timezone' => '(UTC+10:00) Canberra, Melbourne, Sydney',
            'main_client_id' => null,
            'overview' => 'this is apple company',
            'rating' => 5,
            'status' => ClientStatusEnum::ACTIVE,
            'logo_file_id' => null,
            'designated_designer_id' => null
        ];

        $client = new Client();
        $client->setAttribute('id', 1);
        $client->setName('Test Company Demo');
        $client->setClientCode('TCP');
        $client->setAddress('123 Clyde St, Batemans Bay NSW 2536');
        $client->setPhone('(02) 4472 9131');
        $client->setTimezone('(UTC+10:00) Canberra, Melbourne, Sydney');
        $client->setMainClientId(null);
        $client->setOverview('this is apple company');
        $client->setRating(5);
        $client->setStatus(new ClientStatusEnum(ClientStatusEnum::ACTIVE));
        $client->setLogoFileId(null);
        $client->setDesignatedDesignerId(null);

        $actual = [
            'id' => $client->getId(),
            'name' => $client->getName(),
            'client_code' => $client->getClientCode(),
            'address' => $client->getAddress(),
            'phone' => $client->getPhone(),
            'timezone' => $client->getTimezone(),
            'main_client_id' => $client->getMainClientId(),
            'overview' => $client->getOverview(),
            'rating' => $client->getRating(),
            'status' => $client->getStatus(),
            'logo_file_id' => $client->getLogoFileId(),
            'designated_designer_id' => $client->getDesignatedDesignerId()
        ];

        self::assertEquals($expected, $actual);
    }
 }
