<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class EventBookingTypesEnum extends Enum
{
    /**
     * @var string
     */
    public const HALF_DAY = 'Half Day Booking';

    /**
     * @var string
     */
    public const FULL_DAY = 'Full Day Booking';

    /**
     * @var string
     */
    public const MULTIPLE_DAY = 'Multiple Day Booking';
}
