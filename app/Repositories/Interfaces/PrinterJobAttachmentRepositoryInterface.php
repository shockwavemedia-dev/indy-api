<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PrinterJobAttachmentRepositoryInterface
{
    public function findByIds(array $ids): Collection;
}
