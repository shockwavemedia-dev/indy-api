<?php

declare(strict_types=1);

namespace App\Services\Libraries\Resources;

use App\Models\File;
use App\Models\Library;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class LibraryProcessResource extends DataTransferObject
{
    public File $file;

    public Library $library;

    public UploadedFile $uploadedFile;

    public User $user;

    public function getFile(): File
    {
        return $this->file;
    }

    public function getLibrary(): Library
    {
        return $this->library;
    }

    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setFile(File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function setLibrary(Library $library): self
    {
        $this->library = $library;

        return $this;
    }

    public function setUploadedFile(UploadedFile $uploadedFile): self
    {
        $this->uploadedFile = $uploadedFile;

        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
