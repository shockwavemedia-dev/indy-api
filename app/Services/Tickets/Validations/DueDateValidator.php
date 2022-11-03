<?php

declare(strict_types=1);

namespace App\Services\Tickets\Validations;

use App\Services\Tickets\Exceptions\InvalidDueDateException;
use App\Services\Tickets\Interfaces\Validations\DueDateValidatorInterface;
use Carbon\Carbon;

final class DueDateValidator implements DueDateValidatorInterface
{
    /**
     * @throws \App\Services\Tickets\Exceptions\InvalidDueDateException
     */
    public function validate(Carbon $from, Carbon $dueDate, int $days): bool
    {
        if ($days === 0) {
            return true;
        }

        $minDate = $from->addDays($days);

       if ($dueDate->startOfDay()->gte($minDate->startOfDay())) {
           return true;
        }

        throw new InvalidDueDateException(
            \sprintf(
                'Due date should be more than or equal %s days',
                $days
            ),
        );
    }
}
