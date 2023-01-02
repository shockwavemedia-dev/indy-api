<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\LibraryCategories;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\LibraryCategories\LibraryCategoryResource;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ShowLibraryCategoryController extends AbstractAPIController
{
    private LibraryCategoryRepositoryInterface $libraryCategoryRepository;

    public function __construct(LibraryCategoryRepositoryInterface $libraryCategoryRepository)
    {
        $this->libraryCategoryRepository = $libraryCategoryRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var \App\Models\LibraryCategory $libraryCategory */
        $libraryCategory = $this->libraryCategoryRepository->find($id);

        if ($libraryCategory === null) {
            return $this->respondNotFound([
                'message' => 'Library Category not found.',
            ]);
        }

        return new LibraryCategoryResource($libraryCategory);
    }
}
