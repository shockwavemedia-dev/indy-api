<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class SocialMediaStatusesEnum extends Enum
{
    public const APPROVED = 'Approved';

    public const CLIENT_CREATED_DRAFT = 'Client Created Draft';

    public const IN_PROGRESS = 'In Progress';

    public const TO_APPROVE = 'To Approve';

    public const TODO = 'To Do';

    public const SCHEDULED = 'Scheduled';
}
