<?php

declare(strict_types=1);

namespace App\Http\Resources\API\LibraryCategories;

use App\Http\Resources\Resource;

final class LibraryCategoriesResource extends Resource
{
    protected function getResponse(): array
    {
        $libraryCategories = [];

        foreach ($this->resource as $libraryCategory) {
            $libraryCategories['data'][] = new LibraryCategoryResource($libraryCategory);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $libraryCategories['page'] = $this->paginationResource($this->resource);

        return $libraryCategories;
    }
}
