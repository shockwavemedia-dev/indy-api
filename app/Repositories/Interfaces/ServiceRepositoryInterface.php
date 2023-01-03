<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ServiceRepositoryInterface
{
    public function all(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function findByIds(array $ids): Collection;

    public function findByName(string $name): ?Service;

    public function findByNames(array $names): Collection;

    public function updateServiceExtras(Service $service, array $extras): Service;
}
