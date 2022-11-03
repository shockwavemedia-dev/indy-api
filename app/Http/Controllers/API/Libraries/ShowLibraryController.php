<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Libraries;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Libraries\LibraryResource;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ShowLibraryController extends AbstractAPIController
{

    private LibraryRepositoryInterface $libraryRepository;

    public function __construct(LibraryRepositoryInterface $libraryRepository)
    {
        $this->libraryRepository = $libraryRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        $library = $this->libraryRepository->find($id);

        if ($library === null) {
            return $this->respondNotFound([
                'message' => 'Library not found.',
            ]);
        }

        return new LibraryResource($library, true);
    }
}
