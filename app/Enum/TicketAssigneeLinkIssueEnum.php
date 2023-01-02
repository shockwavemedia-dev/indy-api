<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class TicketAssigneeLinkIssueEnum extends Enum
{
    /**
     * @var string
     */
    public const BLOCKS = 'blocks';

    /**
     * @var string
     */
    public const BLOCKED_BY = 'blocked by';

    public const LINKEDISSUE = [
        self::BLOCKS => self::BLOCKED_BY,
        self::BLOCKED_BY => self::BLOCKS,
    ];

    public function getOppositeLinkedIssue(): self
    {
        return new TicketAssigneeLinkIssueEnum(self::LINKEDISSUE[$this->getValue()]);
    }
}
