<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Libraries;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeleteLibraryController extends AbstractAPIController
{
    private LibraryRepositoryInterface $libraryRepository;

    private ErrorLogInterface $sentryHandler;

    public function __construct(LibraryRepositoryInterface $libraryRepository, ErrorLogInterface $sentryHandler)
    {
        $this->sentryHandler = $sentryHandler;
        $this->libraryRepository = $libraryRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        $library = $this->libraryRepository->find($id);

        if ($library === null) {
            return $this->respondNoContent();
        }

        try {
            $this->libraryRepository->delete($library);
        } catch (\Throwable $exception) {
            $this->sentryHandler->reportError($exception);
        } finally {
            return $this->respondNoContent();
        }
    }
}
