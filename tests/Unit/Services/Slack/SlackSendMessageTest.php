<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Slack;

use App\Services\Slack\Exceptions\SlackSendMessageException;
use App\Services\Slack\Resources\SlackUserResource;
use App\Services\Slack\SlackSendMessage;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\ThirdParty\Vluzrmos\SlackApi\Contracts\SlackChatStub;

/**
 * @covers \App\Services\Slack\SlackSendMessage
 */
final class SlackSendMessageTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\Slack\Exceptions\SlackSendMessageException
     */
    public function testSendMessageSuccess(): void
    {
        $resource = new SlackUserResource([
            'slackId' => 1,
            'name' => 'test',
        ]);

        $slackChat = new SlackChatStub([
            'message' => (object) [
                'ok' => true,
            ],
        ]);

        $expectedCall = [
            [
                'message' => [
                    1,
                    'test',
                    [],
                ],
            ],
        ];

        $service = new SlackSendMessage($slackChat);

        $service->sendMessage($resource, 'test', []);

        self::assertEquals($expectedCall, $slackChat->getCalls());
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\Slack\Exceptions\SlackSendMessageException
     */
    public function testSendMessageThrowSlackSendMessageException(): void
    {
        $resource = new SlackUserResource([
            'slackId' => 1,
            'name' => 'test',
        ]);

        $slackChat = new SlackChatStub([
            'message' => (object) [
                'ok' => false,
                'error' => 'test',
            ],
        ]);

        $expectedCall = [
            [
                'message' => [
                    1,
                    'test',
                    [],
                ],
            ],
        ];

        $service = new SlackSendMessage($slackChat);

        self::expectException(SlackSendMessageException::class);

        $service->sendMessage($resource, 'test', []);

        self::assertEquals($expectedCall, $slackChat->getCalls());
    }
}
