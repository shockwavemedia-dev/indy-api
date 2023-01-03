<?php

declare(strict_types=1);

namespace App\Http\Resources\API\MarketingPlanners;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\File;

final class FileResource extends Resource
{
    /**
     * @throws \App\Exceptions\InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof File) === false) {
            throw new InvalidResourceTypeException(
                File::class
            );
        }

        /** @var \App\Models\File $file */
        $file = $this->resource;

        return [
            'name' => $file->getOriginalFilename(),
            'folder_id' => $file->getFolder()?->getId(),
            'generated_name' => $file->getFileName(),
            'signed_url' => $file->getUrl(),
            'thumbnail_url' => $file->getThumbnailUrl(),
            'signed_url_expiration' => $file->getUrlExpiration(),
            'directory' => $file->getFilePath(),
            'file_type' => $file->getFileType(),
        ];
    }
}
