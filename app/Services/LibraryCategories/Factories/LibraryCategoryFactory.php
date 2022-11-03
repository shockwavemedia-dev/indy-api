<?php

declare(strict_types=1);

namespace App\Services\LibraryCategories\Factories;

use App\Models\LibraryCategory;
use App\Models\User;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use App\Services\LibraryCategories\Interfaces\LibraryCategoryFactoryInterface;
use App\Services\LibraryCategories\Resources\CreateLibraryCategoryResource;

final class LibraryCategoryFactory implements LibraryCategoryFactoryInterface
{
    private LibraryCategoryRepositoryInterface $libraryCategoryRepository;

    public function __construct(LibraryCategoryRepositoryInterface $libraryCategoryRepository) {
        $this->libraryCategoryRepository = $libraryCategoryRepository;
    }
    public function make(User $user, CreateLibraryCategoryResource $resource): LibraryCategory
    {
        $exist = $this->libraryCategoryRepository->findByName($resource->getName());

        if ($exist !== null) {
            return $exist;
        }

        /** @var LibraryCategory $libraryCategory */
        $libraryCategory = $this->libraryCategoryRepository->create([
           'name' => $resource->getName(),
            'slug' => $resource->getSlug(),
            'created_by' => $user->getId(),
        ]);

        return $libraryCategory;
    }
}
