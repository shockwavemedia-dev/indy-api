<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Models\Library;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use App\Services\Libraries\Resources\CreateLibraryResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class LibraryRepositoryStub extends AbstractStub implements LibraryRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function all(
        ?int $size = null,
        ?int $pageNumber = null,
        ?int $libraryCategoryId = null
    ): LengthAwarePaginator {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function create(array $attributes): Library
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function update(Library $library, CreateLibraryResource $resource): Library
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
