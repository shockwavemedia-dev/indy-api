<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\LibraryCategories;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\LibraryCategories\LibraryCategoriesResource;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListLibraryCategoryController extends AbstractAPIController
{
    private LibraryCategoryRepositoryInterface $libraryCategoryRepository;

    public function __construct(LibraryCategoryRepositoryInterface $libraryCategoryRepository)
    {
        $this->libraryCategoryRepository = $libraryCategoryRepository;
    }

    public function __invoke(PaginationRequest $request): JsonResource
    {
        $size = $request->getSize() ?? 150;
        $libraryCategories = $this->libraryCategoryRepository->all(
            $size,
            $request->getPageNumber()
        );

        return new LibraryCategoriesResource($libraryCategories);
    }
}
