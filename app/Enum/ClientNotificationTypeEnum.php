<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class ClientNotificationTypeEnum extends Enum
{
    /**
     * @var string
     */
    public const ASSIGNED = 'assigned';

    /**
     * @var string
     */
    public const FILE_FEEDBACK = 'file_feedback';

    /**
     * @var string
     */
    public const TICKET_ASSIGNEE_STATUS = 'ticket_assignee_status';

    /**
     * @var string
     */
    public const TICKET_EMAILS = 'ticket_emails';

    /**
     * @var string
     */
    public const TICKET_FILE_UPLOADED = 'ticket_file_uploaded';

    /**
     * @var string
     */
    public const TICKET_NOTES = 'ticket_notes';

    /**
     * @var string
     */
    public const UPDATED = 'updated';
}
