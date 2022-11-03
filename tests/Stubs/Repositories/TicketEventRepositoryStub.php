<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Models\File;
use App\Models\Tickets\TicketEvent;
use App\Repositories\Interfaces\TicketEventRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketEventRepositoryStub extends AbstractStub implements TicketEventRepositoryInterface
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
    public function updateTicketAttachment(File $file, TicketEvent $ticketEvent): TicketEvent
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}


