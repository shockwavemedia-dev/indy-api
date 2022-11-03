<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class EventServiceTypesEnum extends Enum
{
    /**
     * @var string
     */
    public const PHOTOGRAPHY = 'Photography';

    /**
     * @var string
     */
    public const PHOTOGRAPHY_AND_VIDEOGRAPHY = 'Photography & Videography';

    /**
     * @var string
     */
    public const VIDEOGRAPHY = 'Videography';


}
