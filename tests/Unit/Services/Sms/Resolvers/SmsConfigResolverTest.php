<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Sms\Resolvers;

use App\Services\SMS\Resolvers\SmsConfigResolver;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\ThirdParty\Illuminate\Config\Repository\ConfigStub;

/**
 * @covers \App\Services\SMS\Resolvers\SmsConfigResolver
 */
final class SmsConfigResolverTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testResolveSuccess(): void
    {
        $repository = new ConfigStub([
            'get' => [
                'username' => 'test',
                'password' => 'test',
                'url' => 'test',
            ],
        ]);

        $resolver = new SmsConfigResolver($repository);

        $result = $resolver->resolve();

        self::assertEquals(
            [
                'test',
                'test',
                'test',
            ],
            [
                $result->getUrl(),
                $result->getPassword(),
                $result->getUsername(),
            ]
        );
    }
}
