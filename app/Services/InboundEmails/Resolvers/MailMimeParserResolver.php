<?php

declare(strict_types=1);

namespace App\Services\InboundEmails\Resolvers;

use App\Services\InboundEmails\Interfaces\MailMimeParserResolverInterface;
use ZBateson\MailMimeParser\IMessage;
use ZBateson\MailMimeParser\MailMimeParser;

final class MailMimeParserResolver implements MailMimeParserResolverInterface
{
    public function resolve(string $resource): IMessage
    {
        $parser = new MailMimeParser();

        return $parser->parse($resource, true);
    }
}
