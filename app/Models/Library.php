<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\HasRelationshipWithUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Library extends AbstractModel
{
    use HasFactory, HasRelationshipWithUser, HasDates;

    /**
     * @var string[]
     */
    protected $fillable = [
        'library_category_id',
        'title',
        'description',
        'video_link',
        'file_id',
        'created_by',
        'updated_by',
        'updated_at',
    ];

    protected $table = 'libraries';

    public function getDescription(): ?string
    {
        return $this->getAttribute('description');
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getFileId(): ?int
    {
        return $this->getAttribute('file_id');
    }

    public function getLibraryCategory(): LibraryCategory
    {
        return $this->libraryCategory;
    }

    public function getLibraryCategoryId(): ?int
    {
        return $this->getAttribute('library_category_id');
    }

    public function getTitle(): string
    {
        return $this->getAttribute('title');
    }

    public function getVideoLink(): ?string
    {
        return $this->getAttribute('video_link');
    }

    public function setDescription(?string $description = null): self
    {
        $this->setAttribute('description', $description);

        return $this;
    }

    public function setFile(File $file): self
    {
        $this->file()->associate($file);

        return $this;
    }

    public function setLibraryCategory(LibraryCategory $libraryCategory): self
    {
        $this->libraryCategory()->associate($libraryCategory);

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->setAttribute('title', $title);

        return $this;
    }

    public function setVideoLink(?string $videoLink = null): self
    {
        $this->setAttribute('video_link', $videoLink);

        return $this;
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function libraryCategory(): BelongsTo
    {
        return $this->belongsTo(LibraryCategory::class, 'library_category_id');
    }
}
