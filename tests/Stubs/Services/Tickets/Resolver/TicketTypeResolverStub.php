<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\Tickets\Resolver;

use App\Enum\TicketTypeEnum;
use App\Models\Tickets\Ticket;
use App\Services\Tickets\Interfaces\Resolvers\TicketTypeResolverInterface;
use App\Services\Tickets\Resources\CreateTicketResource;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketTypeResolverStub extends AbstractStub implements TicketTypeResolverInterface
{
    /**
     * @throws \Throwable
     */
    public function create(CreateTicketResource $resource): Ticket
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function supports(TicketTypeEnum $type): bool
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
