<?php

declare(strict_types=1);

namespace App\Services\Tickets\Interfaces\Validations;

use Carbon\Carbon;

interface DueDateValidatorInterface
{
    /**
     * @throws \App\Services\Tickets\Exceptions\InvalidDueDateException
     */
    public function validate(Carbon $from, Carbon $dueDate, int $days): bool;
}
