<?php

declare(strict_types=1);

namespace App\Services\Sorting\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface SortByYearAndMonthResolverInterface
{
    public function resolve(Collection $data): array;
}
