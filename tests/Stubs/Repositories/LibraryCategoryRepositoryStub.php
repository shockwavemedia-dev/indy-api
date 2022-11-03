<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Models\LibraryCategory;
use App\Models\User;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use App\Services\LibraryCategories\Resources\CreateLibraryCategoryResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class LibraryCategoryRepositoryStub extends AbstractStub implements LibraryCategoryRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function all(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function create(array $attributes): Model
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function update(
        LibraryCategory $libraryCategory,
        CreateLibraryCategoryResource $resource,
        User $user
    ): LibraryCategory {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findByName(string $name): ?LibraryCategory
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}


