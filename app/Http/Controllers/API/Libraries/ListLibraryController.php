<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Libraries;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Libraries\LibrariesResource;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListLibraryController extends AbstractAPIController
{
    private LibraryRepositoryInterface $libraryRepository;

    public function __construct(LibraryRepositoryInterface $libraryRepository)
    {
        $this->libraryRepository = $libraryRepository;
    }

    public function __invoke(PaginationRequest $request): JsonResource
    {
        $size = $request->getSize() ?? 150;

        $library = $this->libraryRepository->all(
            $size,
            $request->getPageNumber(),
            $request->getLibraryCategoryId(),
        );

        return new LibrariesResource($library);
    }
}
