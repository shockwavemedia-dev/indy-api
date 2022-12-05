<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Tickets\ClientTicketFile;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

final class File extends AbstractModel
{
    use SoftDeletes, HasFactory;

    /**
     * @var string[]
     */
    protected $dates = [
        'url_expiration',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'client_id',
        'original_filename',
        'bucket',
        'file_name',
        'file_extension',
        'file_size',
        'file_path',
        'file_type',
        'folder_id',
        'uploaded_by',
        'deleted_by',
        'disk',
        'version',
        'signed',
        'thumbnail_url',
        'unique_name',
        'url',
        'url_expiration',
        'thumbnail_filepath',
    ];

    protected $table = 'files';

    public function getBucket(): ?string
    {
        return $this->getAttribute('bucket');
    }

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getUploadedBy(): User
    {
        return $this->uploadedBy;
    }

    public function getUploadedById(): int
    {
        return $this->attributes('uploaded_by');
    }

    public function getDeletedById(): int
    {
        return $this->attributes('deleted_by');
    }

    public function getClientTicketFile(): ?ClientTicketFile
    {
        return $this->clientTicketFile;
    }

    public function getDisk(): string
    {
        return $this->getAttribute('disk');
    }

    public function getFileExtension(): ?string
    {
        return $this->getAttribute('file_extension');
    }

    public function getFileName(): string
    {
        return $this->getAttribute('file_name');
    }

    public function getFilePath(): string
    {
        return $this->getAttribute('file_path');
    }

    public function getFileSize(): int
    {
        return $this->getAttribute('file_size');
    }

    public function getFileType(): string
    {
        return $this->getAttribute('file_type');
    }

    public function getFileDisk(): string
    {
        return $this->getAttribute('disk');
    }

    public function getFolder(): ?Folder
    {
        return $this->folder;
    }

    public function getOriginalFilename(): string
    {
        return $this->getAttribute('original_filename');
    }

    public function getThumbnailFilepath(): ?string
    {
        return $this->getAttribute('thumbnail_filepath');
    }

    public function getThumbnailUrl(): ?string
    {
        return $this->getAttribute('thumbnail_url');
    }

    public function getUrl(): ?string
    {
        return $this->getAttribute('url');
    }

    public function getUrlExpiration(): ?DateTimeInterface
    {
        return $this->getAttribute('url_expiration');
    }

    public function getVersion(): int
    {
        return (int) $this->getAttribute('version');
    }

    public function setBucket(?string $bucket = null): self
    {
        $this->setAttribute('bucket', $bucket);

        return $this;
    }

    public function setDisk(string $disk): self
    {
        $this->setAttribute('disk', $disk);

        return $this;
    }

    public function setFileName(string $filename): self
    {
        $this->setAttribute('file_name', $filename);

        return $this;
    }

    public function setFilePath(string $filepath): self
    {
        $this->setAttribute('file_path', $filepath);

        return $this;
    }

    public function setFileType(string $filetype): self
    {
        $this->setAttribute('file_type', $filetype);

        return $this;
    }

    public function setFileSize(int $filesize): self
    {
        $this->setAttribute('file_size', $filesize);

        return $this;
    }

    public function setOriginalFilename(string $originalName): self
    {
        $this->setAttribute('original_filename', $originalName);

        return $this;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->setAttribute('unique_name', $uniqueName);

        return $this;
    }

    public function setUrl(?string $url = null): self
    {
        $this->setAttribute('url', $url);

        return $this;
    }

    public function setThumbnailUrl(?string $thumbnailUrl = null): self
    {
        $this->setAttribute('thumbnail_url', $thumbnailUrl);

        return $this;
    }

    public function setUrlExpiration(?DateTimeInterface $dateExpiry = null): self
    {
        $this->setAttribute('url_expiration', $dateExpiry);

        return $this;
    }

    public function setVersion(int $version): self
    {
        $this->setAttribute('version', $version);

        return $this;
    }

    public function clientTicketFile(): ?HasOne
    {
        return $this->hasOne(ClientTicketFile::class, 'file_id');
    }

    public function folder(): ?BelongsTo
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
