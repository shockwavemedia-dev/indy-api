<?php

declare(strict_types=1);

namespace App\Services\Libraries\Factories;

use App\Models\Library;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use App\Services\Libraries\Interfaces\Factories\LibraryFactoryInterface;
use App\Services\Libraries\Resources\CreateLibraryResource;

final class LibraryFactory implements LibraryFactoryInterface
{
    private LibraryRepositoryInterface $libraryRepository;

    public function __construct(LibraryRepositoryInterface $libraryRepository)
    {
        $this->libraryRepository = $libraryRepository;
    }

    public function make(CreateLibraryResource $resource): Library
    {
        /** @var Library $library */
        $library = $this->libraryRepository->create([
            'library_category_id' => $resource->getLibraryCategoryId(),
            'title' => $resource->getTitle(),
            'description' => $resource->getDescription(),
            'video_link' => $resource->getVideLink(),
            'file_id' => $resource->getFile()?->getId(),
            'created_by' => $resource->getCreatedBy()->getId(),
        ]);

        return $library;
    }
}
