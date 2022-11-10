<?php

declare(strict_types=1);

namespace App\Services\InboundEmails\Interfaces;

use ZBateson\MailMimeParser\IMessage;

interface MailMimeParserResolverInterface
{
    public function resolve(string $resource): IMessage;
}
