<?php

declare(strict_types=1);

namespace App\Services\LibraryCategories\Interfaces;

use App\Models\LibraryCategory;
use App\Models\User;
use App\Services\LibraryCategories\Resources\CreateLibraryCategoryResource;

interface LibraryCategoryFactoryInterface
{
    public function make(User $user, CreateLibraryCategoryResource $resource): LibraryCategory;
}
