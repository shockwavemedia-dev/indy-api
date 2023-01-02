<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\LibraryCategories;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeleteLibraryCategoryController extends AbstractAPIController
{
    private LibraryCategoryRepositoryInterface $libraryCategoryRepository;

    public function __construct(
        LibraryCategoryRepositoryInterface $libraryCategoryRepository,
        ErrorLogInterface $sentryHandler
    ) {
        $this->libraryCategoryRepository = $libraryCategoryRepository;
        $this->sentryHandler = $sentryHandler;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var \App\Models\LibraryCategory $libraryCategory */
        $libraryCategory = $this->libraryCategoryRepository->find($id);

        if ($libraryCategory === null) {
            return $this->respondNoContent();
        }

        try {
            $this->libraryCategoryRepository->delete($libraryCategory);

            return $this->respondNoContent();
        } catch (\Throwable $exception) {
            $this->sentryHandler->log($exception->getMessage());

            return $this->respondNoContent();
        }
    }
}
