<?php

namespace App\Services\SocialMedia\Interfaces;

use App\Models\Client;

interface SocialMediaCalendarMonthResolverInterface
{
    public function resolve(
        Client $client,
        int $month,
        int $year
    ): array;
}
