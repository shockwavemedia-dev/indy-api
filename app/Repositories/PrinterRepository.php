<?php

namespace App\Repositories;

use App\Models\Printer;
use App\Repositories\Interfaces\PrinterRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PrinterRepository extends BaseRepository implements PrinterRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Printer());
    }

    public function findAll(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($size, ['*'], null, $pageNumber);
    }
}
