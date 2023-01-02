<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\LibraryCategory;
use App\Models\User;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use App\Services\LibraryCategories\Resources\CreateLibraryCategoryResource;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class LibraryCategoryRepository extends BaseRepository implements LibraryCategoryRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new LibraryCategory());
    }

    public function all(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model->orderBy('name', 'asc')->paginate($size, ['*'], null, $pageNumber);
    }

    public function update(
        LibraryCategory $libraryCategory,
        CreateLibraryCategoryResource $resource,
        User $user
    ): LibraryCategory {
        $libraryCategory->setSlug($resource->getSlug());
        $libraryCategory->setName($resource->getName());
        $libraryCategory->setUpdatedBy($user);
        $libraryCategory->setUpdatedAt(new Carbon());
        $libraryCategory->save();

        return $libraryCategory;
    }

    public function findByName(string $name): ?LibraryCategory
    {
        return $this->model->where('name', '=', $name)->first();
    }
}
