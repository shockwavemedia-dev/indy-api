<?php

declare(strict_types=1);

namespace App\Http\Resources\API\LibraryCategories;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\LibraryCategory;

final class LibraryCategoryResource extends Resource
{
    /**
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof LibraryCategory) === false) {
            throw new InvalidResourceTypeException(
                LibraryCategory::class,
            );
        }

        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->getName(),
            'slug' => $this->resource->getSlug(),
        ];
    }
}
