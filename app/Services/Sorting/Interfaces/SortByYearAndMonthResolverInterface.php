<?php

declare(strict_types=1);

namespace App\Services\Sorting\Interfaces;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

interface SortByYearAndMonthResolverInterface
{
    public function resolve(Client $client, Collection $data): array;
}
