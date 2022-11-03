<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class BackendUserNotificationTypeEnum extends Enum
{
    /**
     * @var string
     */
    public const ASSIGNED_TICKET = 'assigned_ticket';

    /**
     * @var string
     */
    public const FILE_APPROVED = 'file_approved';

    /**
     * @var string
     */
    public const FILE_FEEDBACK = 'file_feedback';

    /**
     * @var string
     */
    public const TICKET_NOTES = 'ticket_notes';

    /**
     * @var string
     */
    public const SUPPORT_REQUEST = 'support_request';

}
