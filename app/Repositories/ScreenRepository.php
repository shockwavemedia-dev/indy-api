<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Screen;
use App\Repositories\Interfaces\ScreenRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final class ScreenRepository extends BaseRepository implements ScreenRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Screen());
    }

    public function findAll(?int $size, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model
            ->with('createdBy')
            ->orderBy('created_at', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}
