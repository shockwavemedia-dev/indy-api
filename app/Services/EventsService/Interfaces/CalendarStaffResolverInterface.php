<?php

namespace App\Services\EventsService\Interfaces;

use App\Models\Client;

interface CalendarStaffResolverInterface
{
    public function resolve(
        Client $client,
        int $month,
        int $year
    ): array;
}
