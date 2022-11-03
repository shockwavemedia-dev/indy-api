<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final class ServiceRepository extends BaseRepository implements ServiceRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Service());
    }

    public function all(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model->paginate($size, ['*'], null, $pageNumber);
    }

    public function findByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)
            ->get();
    }

    public function findByName(string $name): ?Service
    {
        return $this->model->where('name', '=', $name)
            ->first();
    }

    public function findByNames(array $names): Collection
    {
        return $this->model->whereIn('name', $names)->get();
    }

    public function updateServiceExtras(Service $service, array $extras): Service
    {
        $service = $service->setAttribute('extras', $extras);
        $service->save();

        return $service;
    }
}
