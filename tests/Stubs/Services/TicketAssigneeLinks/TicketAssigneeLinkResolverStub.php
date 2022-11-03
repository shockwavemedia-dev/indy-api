<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\TicketAssigneeLinks;

use App\Services\TicketAssigneeLinks\Interfaces\TicketAssigneeLinkResolverInterface;
use App\Services\TicketAssigneeLinks\Resources\CreateTicketAssigneeLinkResource;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketAssigneeLinkResolverStub extends AbstractStub implements TicketAssigneeLinkResolverInterface
{
    /**
     * @throws \Throwable
     */
    public function resolve(CreateTicketAssigneeLinkResource $resource): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }
}
