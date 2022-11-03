<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class EventShootTypesEnum extends Enum
{
    /**
     * @var string
     */
    public const ARCHITECTURE_VENUE = 'Architecture/Venue';

    /**
     * @var string
     */
    public const EVENT_SHOOT = 'Event Shoot';

    /**
     * @var string
     */
    public const FOOD_PHOTOGRAPHY = 'Food Photography';


    /**
     * @var string
     */
    public const STAFF_HEADSHOTS = 'Staff/Headshots';


}
