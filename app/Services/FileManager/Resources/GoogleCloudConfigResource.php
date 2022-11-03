<?php

declare(strict_types=1);

namespace App\Services\FileManager\Resources;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class GoogleCloudConfigResource extends DataTransferObject
{
    public string $projectId;

    public string $keyFilePath;

    public function getProjectId(): string
    {
        return $this->projectId;
    }

    public function getKeyFilePath(): string
    {
        return $this->keyFilePath;
    }

    public function setProjectId(string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function setKeyFilePath(string $keyFilePath): self
    {
        $this->keyFilePath = $keyFilePath;

        return $this;
    }
}
