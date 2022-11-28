<?php

declare(strict_types=1);

namespace App\Services\Files\Resources;

use App\Models\Client;
use App\Models\Folder;
use App\Models\User;
use DateTimeInterface;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateFileResource extends DataTransferObject
{
    public ?Client $client;

    public ?Folder $folder = null;

    public ?User $deletedBy = null;

    public UploadedFile $uploadedFile;

    public ?string $bucket = null;

    public string $disk;

    public ?string $fileName = null;

    public ?string $filePath = null;

    public ?string $fileExtension = null;

    public User $uploadedBy;

    public ?string $url = null;

    public ?DateTimeInterface $urlExpiration = null;

    public function getFileExtension(): ?string
    {
        return $this->fileExtension;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function getBucket(): ?string
    {
        return $this->bucket;
    }

    public function setBucket(?string $bucket = null): self
    {
        $this->bucket = $bucket;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function getFolder(): ?Folder
    {
        return $this->folder;
    }

    public function setFileName(?string $fileName = null): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }

    public function setUploadedFile(UploadedFile $uploadedFile): self
    {
        $this->uploadedFile = $uploadedFile;

        return $this;
    }

    public function getDeletedBy(): ?User
    {
        return $this->deletedBy;
    }

    public function getDisk(): string
    {
        return $this->disk;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function getUploadedBy(): User
    {
        return $this->uploadedBy;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getUrlExpiration(): ?DateTimeInterface
    {
        return $this->urlExpiration;
    }

    public function setDeletedBy(?User $deletedBy = null): self
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    public function setDisk(string $disk): self
    {
        $this->disk = $disk;

        return $this;
    }

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function setUploadedBy(User $uploadedBy): self
    {
        $this->uploadedBy = $uploadedBy;

        return $this;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setUrlExpiration(?DateTimeInterface $urlExpiration): self
    {
        $this->urlExpiration = $urlExpiration;

        return $this;
    }
}
