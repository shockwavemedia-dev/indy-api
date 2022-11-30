<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Slack\Resolvers;

use App\Models\User;
use App\Services\Slack\Exceptions\SlackUserNullException;
use App\Services\Slack\Resolvers\SlackUserResolver;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\ThirdParty\Vluzrmos\SlackApi\Contracts\SlackUserStub;

/**
 * @covers \App\Services\Slack\Resolvers\SlackUserResolver
 */
final class SlackUserResolverTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\Slack\Exceptions\SlackUserNullException
     */
    public function testFindSlackUserSuccess(): void
    {
        $data = (object) [
            'user' => (object) [
                'id' => 1,
                'profile' => (object) [
                    'display_name' => 'test',
                ],
            ],
            'ok' => true,
        ];

        $slackUser = new SlackUserStub([
            'lookupByEmail' => (object) $data,
        ]);

        $user = new User();
        $user->setEmail('test@test.com');

        $resolver = new SlackUserResolver($slackUser);

        $expected = [
            'slackId' => 1,
            'name' => 'test',
        ];

        $expectedCall = [
            [
                'lookupByEmail' => [
                    $user->getEmail(),
                ],
            ],
        ];

        $result = $resolver->findSlackUser($user);

        $actual = [
            'slackId' => $result->getSlackId(),
            'name' => $result->getName(),
        ];

        self::assertEquals($expectedCall, $slackUser->getCalls());
        self::assertEquals($expected, $actual);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\Slack\Exceptions\SlackUserNullException
     */
    public function testFindSlackUserThrowSlackUserNullException(): void
    {
        $data = (object) [
            'ok' => false,
        ];

        $slackUser = new SlackUserStub([
            'lookupByEmail' => (object) $data,
        ]);

        $user = new User();
        $user->setEmail('test@test.com');

        $resolver = new SlackUserResolver($slackUser);

        self::expectException(SlackUserNullException::class);

        $result = $resolver->findSlackUser($user);
    }
}
