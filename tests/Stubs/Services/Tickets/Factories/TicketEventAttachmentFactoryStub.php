<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\Tickets\Factories;

use App\Models\Tickets\TicketEventAttachment;
use App\Services\Tickets\Interfaces\Factories\TicketEventAttachmentFactoryInterface;
use App\Services\Tickets\Resources\CreateTicketEventAttachmentResource;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketEventAttachmentFactoryStub extends AbstractStub implements TicketEventAttachmentFactoryInterface
{
    /**
     * @throws \Throwable
     */
    public function make(CreateTicketEventAttachmentResource $resource): TicketEventAttachment
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
