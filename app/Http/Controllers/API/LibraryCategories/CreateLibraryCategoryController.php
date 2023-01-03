<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\LibraryCategories;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\LibraryCategories\CreateLibraryCategoryRequest;
use App\Http\Resources\API\LibraryCategories\LibraryCategoryResource;
use App\Services\LibraryCategories\Interfaces\LibraryCategoryFactoryInterface;
use App\Services\LibraryCategories\Resources\CreateLibraryCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreateLibraryCategoryController extends AbstractAPIController
{
    private LibraryCategoryFactoryInterface $libraryCategoryFactory;

    public function __construct(LibraryCategoryFactoryInterface $libraryCategoryFactory)
    {
        $this->libraryCategoryFactory = $libraryCategoryFactory;
    }

    public function __invoke(CreateLibraryCategoryRequest $request): JsonResource
    {
        /** @var \App\Models\User $user */
        $user = $this->getUser();

        try {
            $libraryCategory = $this->libraryCategoryFactory->make($user, new CreateLibraryCategoryResource([
                'name' => $request->getName(),
            ]));

            return new LibraryCategoryResource($libraryCategory);
        } catch (\Throwable $exception) {
            return $this->respondInternalError([
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
