<?php

declare(strict_types=1);

namespace App\Services\LibraryCategories\Resources;

use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateLibraryCategoryResource extends DataTransferObject
{
    public string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return Str::slug($this->getName(), '-');
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
