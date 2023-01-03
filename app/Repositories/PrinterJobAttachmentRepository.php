<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PrinterJobAttachment;
use App\Repositories\Interfaces\PrinterJobAttachmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class PrinterJobAttachmentRepository extends BaseRepository implements PrinterJobAttachmentRepositoryInterface
{
    public function __construct(PrinterJobAttachment $model)
    {
        parent::__construct($model);
    }

    public function findByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}
