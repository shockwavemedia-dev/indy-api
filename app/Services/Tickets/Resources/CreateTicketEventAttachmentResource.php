<?php

declare(strict_types=1);

namespace App\Services\Tickets\Resources;

use App\Models\File;
use App\Models\Tickets\TicketEvent;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateTicketEventAttachmentResource extends DataTransferObject
{
    public File $file;

    public TicketEvent $ticketEvent;

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @param  File  $file
     * @return CreateTicketEventAttachmentResource
     */
    public function setFile(File $file): CreateTicketEventAttachmentResource
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return TicketEvent
     */
    public function getTicketEvent(): TicketEvent
    {
        return $this->ticketEvent;
    }

    /**
     * @param  TicketEvent  $ticketEvent
     * @return CreateTicketEventAttachmentResource
     */
    public function setTicketEvent(TicketEvent $ticketEvent): CreateTicketEventAttachmentResource
    {
        $this->ticketEvent = $ticketEvent;

        return $this;
    }
}
