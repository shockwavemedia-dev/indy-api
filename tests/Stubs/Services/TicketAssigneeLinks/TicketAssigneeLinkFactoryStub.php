<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\TicketAssigneeLinks;

use App\Models\Tickets\TicketAssigneeLink;
use App\Services\TicketAssigneeLinks\Interfaces\TicketAssigneeLinkFactoryInterface;
use App\Services\TicketAssigneeLinks\Resources\CreateTicketAssigneeLinkResource;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketAssigneeLinkFactoryStub extends AbstractStub implements TicketAssigneeLinkFactoryInterface
{
    /**
     * @throws \Throwable
     */
    public function make(CreateTicketAssigneeLinkResource $resource): TicketAssigneeLink
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
