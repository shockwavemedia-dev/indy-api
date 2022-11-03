<?php

namespace Tests\Stubs\Repositories;

use App\Enum\TicketAssigneeLinkIssueEnum;
use App\Models\Tickets\TicketAssignee;
use App\Models\Tickets\TicketAssigneeLink;
use App\Repositories\Interfaces\TicketAssigneeLinkRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketAssigneeLinkRepositoryStub extends AbstractStub implements TicketAssigneeLinkRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function create(array $attributes): Model
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findByTwoTicketAssignee(
        TicketAssignee $mainAssignee,
        TicketAssignee $linkAssignee,
        TicketAssigneeLinkIssueEnum $linkIssueEnum
    ): ?Collection {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
