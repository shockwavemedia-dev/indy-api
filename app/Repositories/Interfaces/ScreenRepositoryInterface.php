<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ScreenRepositoryInterface
{
    public function findAll(?int $size, ?int $pageNumber = null): LengthAwarePaginator;

    public function findByIds(array $ids): Collection;
}
