<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Library;
use App\Services\Libraries\Resources\CreateLibraryResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface LibraryRepositoryInterface
{
    public function all(
        ?int $size = null,
        ?int $pageNumber = null,
        ?int $libraryCategoryId = null
    ): LengthAwarePaginator;

    public function update(Library $library, CreateLibraryResource $resource): Library;
}
