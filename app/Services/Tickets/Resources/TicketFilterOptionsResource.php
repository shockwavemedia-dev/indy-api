<?php

declare(strict_types=1);

namespace App\Services\Tickets\Resources;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

final class TicketFilterOptionsResource extends DataTransferObject
{
    public ?array $types = null;

    public ?array $statuses = null;

    public ?string $subject = null;

    public ?string $code = null;

    public ?Carbon $deadline = null;

    public function getTypes(): ?array
    {
        return $this->types;
    }

    public function getStatuses(): ?array
    {
        return $this->statuses;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getDeadline(): ?Carbon
    {
        return $this->deadline;
    }
}
