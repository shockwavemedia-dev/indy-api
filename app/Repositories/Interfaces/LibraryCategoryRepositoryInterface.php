<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\LibraryCategory;
use App\Models\User;
use App\Services\LibraryCategories\Resources\CreateLibraryCategoryResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface LibraryCategoryRepositoryInterface
{
    public function all(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function findByName(string $name): ?LibraryCategory;

    public function update(
        LibraryCategory $libraryCategory,
        CreateLibraryCategoryResource $resource,
        User $user
    ): LibraryCategory;
}
