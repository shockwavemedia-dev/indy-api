<?php

namespace App\Services\InboundEmails\Interfaces;

use App\Models\User;
use ZBateson\MailMimeParser\IMessage;

interface EmailTicketProcessorInterface
{
    public function process(IMessage $message, User $user): void;
}
