<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class EventNumberOfDishesEnum extends Enum
{
    public const ONE_TO_TWENTY = '1-20';

    public const TWENTY_TO_FIFTY = '20-50';

    public const FIFTY_PLUS = '50+';
}
