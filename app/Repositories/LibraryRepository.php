<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Library;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use App\Services\Libraries\Resources\CreateLibraryResource;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class LibraryRepository extends BaseRepository implements LibraryRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Library());
    }

    public function all(
        ?int $size = null,
        ?int $pageNumber = null,
        ?int $libraryCategoryId = null
    ): LengthAwarePaginator {
        return $this->model
            ->with('libraryCategory')
            ->when($libraryCategoryId, function ($query, $libraryCategoryId) {
                return $query->where('library_category_id', '=', $libraryCategoryId);
            })
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function update(Library $library, CreateLibraryResource $resource): Library
    {
        if ($resource->getFile() !== null) {
            $library->setFile($resource->getFile());
        }

        $library->setTitle($resource->getTitle())
            ->setDescription($resource->getDescription())
            ->setVideoLink($resource->getVideLink())
            ->setUpdatedAt(new Carbon())
            ->setUpdatedBy($resource->getUpdatedBy())
            ->setLibraryCategory($resource->getLibraryCategory());
        $library->save();

        return $library;
    }
}
