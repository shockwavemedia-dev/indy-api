<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\LibraryCategories;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\LibraryCategories\CreateLibraryCategoryRequest;
use App\Http\Resources\API\LibraryCategories\LibraryCategoryResource;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use App\Services\LibraryCategories\Resources\CreateLibraryCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdateLibraryCategoryController extends AbstractAPIController
{
    private LibraryCategoryRepositoryInterface $libraryCategoryRepository;

    public function __construct(LibraryCategoryRepositoryInterface $libraryCategoryRepository)
    {
        $this->libraryCategoryRepository = $libraryCategoryRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(int $id, CreateLibraryCategoryRequest $request): JsonResource
    {
        /** @var \App\Models\LibraryCategory $libraryCategory */
        $libraryCategory = $this->libraryCategoryRepository->find($id);

        if ($libraryCategory === null) {
            return $this->respondNotFound([
                'message' => 'Library Category not found.',
            ]);
        }

        /** @var \App\Models\User $user */
        $user = $this->getUser();

        $libraryCategory = $this->libraryCategoryRepository->update(
            $libraryCategory,
            new CreateLibraryCategoryResource([
                'name' => $request->getName(),
            ]),
            $user
        );

        return new LibraryCategoryResource($libraryCategory);
    }
}
