<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Sms;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Services\SMS\Exceptions\SmsApiException;
use App\Services\SMS\Interfaces\SmsClientInterface;
use App\Services\SMS\Interfaces\SmsConfigResolverInterface;
use App\Services\SMS\Resources\SmsConfigResource;
use App\Services\SMS\SmsClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\Stubs\Exceptions\ErrorLogStub;
use Tests\Stubs\Services\Sms\SmsConfigResolverStub;
use Tests\Stubs\ThirdParty\GuzzleHttp\ClientStub;
use Tests\TestCase;

/**
 * @covers \App\Services\SMS\SmsClient
 */
final class SmsClientTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testMakeRequestSuccess(): void
    {
        $responseText = '
        {
            "page": {
                "count": 1,
                "number": 1
            },
            "lists_total": 2,
            "lists": [
                {
                    "id": 6269465,
                    "name": "My Test List",
                    "created": "2022-04-14 01:44:15",
                    "members_active": 1,
                    "fields": [],
                    "members_total": 2
                },
                {
                    "id": 6301433,
                    "name": "untitled list",
                    "created": "2022-04-26 01:08:28",
                    "members_active": 1,
                    "fields": [],
                    "members_total": 1
                }
            ],
            "error": {
                "code": "SUCCESS",
                "description": "OK"
            }
        }
        ';
        $response = new Response(ResponseAlias::HTTP_OK, [], $responseText);
        $client = new ClientStub([
            'request' => $response,
        ]);

        $sentry = new ErrorLogStub();
        $smsConfigResolver = new SmsConfigResolverStub([
            'resolve' => new SmsConfigResource([
                'url' => 'test',
                'username' => 'test',
                'password' => 'test',
            ]),
        ]);

        $smsClient = $this->getSmsClient($client, $sentry, $smsConfigResolver);
        $actual = $smsClient->makeRequest('GET', 'test');

        $this->assertArrayHasKeys([
            'page',
            'lists_total',
            'lists',
            'error',
        ], $actual);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testMakeRequestThrowException(): void
    {
        $responseText = '
        {

            "error": {
                "code": "ERROR",
                "description": "Not Okay"
            }
        }
        ';

        $response = new Response(ResponseAlias::HTTP_BAD_REQUEST, [], $responseText);
        $client = new ClientStub([
            'request' => $response,
        ]);

        $sentry = new ErrorLogStub();
        $smsConfigResolver = new SmsConfigResolverStub([
            'resolve' => new SmsConfigResource([
                'url' => 'test',
                'username' => 'test',
                'password' => 'test',
            ]),
        ]);

        $smsClient = $this->getSmsClient($client, $sentry, $smsConfigResolver);

        self::expectException(SmsApiException::class);

        $smsClient->makeRequest('GET', 'test');
    }

    private function getSmsClient(
        ?ClientInterface $client = null,
        ?ErrorLogInterface $sentryHandler = null,
        ?SmsConfigResolverInterface $configResolver = null
    ): SmsClientInterface {
        return new SmsClient(
            $client ?? new ClientStub(),
            $sentryHandler ?? new ErrorLogStub(),
            $configResolver ?? new SmsConfigResolverStub()
        );
    }
}
