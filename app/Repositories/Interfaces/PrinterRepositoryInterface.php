<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PrinterRepositoryInterface
{
    public function findAll(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;
}
