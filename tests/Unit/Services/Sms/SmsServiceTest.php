<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Sms;

use App\Services\SMS\Resources\SmsContactListResponse;
use App\Services\SMS\Resources\SmsContactListsResponse;
use App\Services\SMS\Resources\SmsMessagesResponse;
use App\Services\SMS\SmsService;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Services\Sms\SmsClientStub;

/**
 * @covers \App\Services\SMS\SmsService
 */
final class SmsServiceTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testGetContactListSuccess(): void
    {
        $arrayResult = [
            'page' => [
                'count' => 1,
                'number' => 1,
            ],
            'lists_total' => 2,
            'lists' => [
                0 => [
                    'id' => 6269465,
                    'name' => 'My Test List',
                    'created' => '2022-04-14 01:44:15',
                    'members_active' => 1,
                    'fields' => [
                    ],
                    'members_total' => 2,
                ],
                1 => [
                    'id' => 6301433,
                    'name' => 'untitled list',
                    'created' => '2022-04-26 01:08:28',
                    'members_active' => 1,
                    'fields' => [
                    ],
                    'members_total' => 1,
                ],
            ],
            'error' => [
                'code' => 'SUCCESS',
                'description' => 'OK',
            ],
        ];

        $client = new SmsClientStub([
            'makeRequest' => $arrayResult,
        ]);

        $service = new SmsService($client);

        $actual = $service->getContactList();

        self::assertEquals(
            (new SmsContactListsResponse($arrayResult))->toArray(),
            $actual->toArray()
        );
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testGetContactListWithDetails(): void
    {
        $arrayResult = [
            'page' => [
                'count' => 1,
                'number' => 1,
            ],
            'members_total' => 2,
            'id' => 6269465,
            'name' => 'My Test List',
            'created' => '2022-04-14 01:44:15',
            'members_active' => 1,
            'fields' => [
            ],
            'members' => [
                0 => [
                    'list_id' => 6269465,
                    'msisdn' => 61420423889,
                    'first_name' => 'Mark',
                    'last_name' => 'Reyta',
                    'created_at' => '2022-04-14 01:44:15',
                    'status' => 'active',
                    'country' => 'AU',
                ],
            ],
            'error' => [
                'code' => 'SUCCESS',
                'description' => 'OK',
            ],
        ];

        $client = new SmsClientStub([
            'makeRequest' => $arrayResult,
        ]);

        $service = new SmsService($client);

        $actual = $service->getContactListWithDetails(123);

        self::assertEquals(
            (new SmsContactListResponse($arrayResult))->toArray(),
            $actual->toArray()
        );
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testGetMessagesSuccess(): void
    {
        $arrayResult = [
            'page' => [
                'count' => 1,
                'number' => 1,
            ],
            'total' => 2,
            'messages' => [
                0 => [
                    'id' => 1798862019,
                    'message_id' => 699429906,
                    'message' => '
Opt-out reply STOP',
                    'sent_at' => '2022-04-26 01:18:39',
                    'msisdn' => 61420423889,
                    'caller_id' => 61429703715,
                    'status' => 'delivered',
                ],
                1 => [
                    'id' => 1798849285,
                    'message_id' => 699419493,
                    'message' => 'Test',
                    'sent_at' => '2022-04-26 01:10:04',
                    'msisdn' => 639157621102,
                    'caller_id' => 639221000115,
                    'status' => 'delivered',
                ],
            ],
            'error' => [
                'code' => 'SUCCESS',
                'description' => 'OK',
            ],
        ];

        $client = new SmsClientStub([
            'makeRequest' => $arrayResult,
        ]);

        $service = new SmsService($client);

        $actual = $service->getMessages();

        self::assertEquals(
            (new SmsMessagesResponse($arrayResult))->toArray(),
            $actual->toArray()
        );
    }
}
