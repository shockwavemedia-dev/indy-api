<?php

declare(strict_types=1);

namespace App\Services\Libraries\Resources;

use App\Models\File;
use App\Models\LibraryCategory;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateLibraryResource extends DataTransferObject
{
    public User $createdBy;

    public ?string $description = null;

    public ?File $file = null;

    public ?int $libraryCategoryId = null;

    public string $title;

    public ?string $videoLink = null;

    public ?User $updatedBy;

    public ?LibraryCategory $libraryCategory = null;

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getLibraryCategoryId(): ?int
    {
        return $this->libraryCategoryId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getVideLink(): ?string
    {
        return $this->videoLink;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function setDescription(?string $description = null): self
    {
        $this->description = $description;

        return $this;
    }

    public function setFile(?File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function setLibraryCategoryId(?int $libraryCategoryId = null): self
    {
        $this->libraryCategoryId = $libraryCategoryId;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setVideLink(?string $videoLink = null): self
    {
        $this->videoLink = $videoLink;

        return $this;
    }

    public function setUpdatedBy(?User $updatedBy = null): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getLibraryCategory(): ?LibraryCategory
    {
        return $this->libraryCategory;
    }

    public function setLibraryCategory(?LibraryCategory $libraryCategory = null): self
    {
        $this->libraryCategory = $libraryCategory;

        return $this;
    }
}
