<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Tickets\Factories;

use App\Enum\TicketTypeEnum;
use App\Services\Tickets\Exceptions\UnsupportedTicketTypeException;
use App\Services\Tickets\Factories\TicketTypeResolverFactory;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Services\Tickets\Resolver\TicketTypeResolverStub;

/**
 * @covers \App\Services\Tickets\Factories\TicketTypeResolverFactory
 */
final class TicketTypeResolverFactoryTest extends TestCase
{
    /**
     * @throws \App\Services\Tickets\Exceptions\UnsupportedTicketTypeException
     */
    public function testMakeSuccess(): void
    {
        $resolver = new TicketTypeResolverStub([
            'supports' => true,
        ]);

        $ticketType = new TicketTypeEnum(TicketTypeEnum::PROJECT);

        $factory = new TicketTypeResolverFactory([$resolver]);

        $expectedCalls = [
            [
                'supports' => [
                    $ticketType
                ],
            ],
        ];

        $factory->make($ticketType);

        $this->assertEquals($expectedCalls, $resolver->getCalls());
    }


    /**
     * @throws \App\Services\Tickets\Exceptions\UnsupportedTicketTypeException
     */
    public function testMakeThrowUnsupportedTicketTypeException(): void
    {
        $resolver = new TicketTypeResolverStub([
            'supports' => false,
        ]);

        $ticketType = new TicketTypeEnum(TicketTypeEnum::PROJECT);

        $factory = new TicketTypeResolverFactory([$resolver]);

        $expectedCalls = [
            [
                'supports' => [
                    $ticketType
                ],
            ],
        ];

        $this->expectException(UnsupportedTicketTypeException::class);

        $factory->make($ticketType);

        $this->assertEquals($expectedCalls, $resolver->getCalls());
    }
}
