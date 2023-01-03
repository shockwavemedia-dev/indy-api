<?php

namespace App\Services\InboundEmails\Interfaces;

use App\Models\Tickets\Ticket;
use ZBateson\MailMimeParser\Message\IMessagePart;

interface EmailAttachmentProcessorInterface
{
    /**
     * @param  Ticket  $ticket
     * @param  IMessagePart[]  $attachments
     * @return void
     */
    public function process(Ticket $ticket, array $attachments): void;
}
