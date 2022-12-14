<?php

declare(strict_types=1);

namespace App\Http\Resources\API\TicketFiles;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Tickets\ClientTicketFile;
use function sprintf;

final class TicketFileResource extends Resource
{
    public static $wrap = null;

    /**
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof ClientTicketFile) === false) {
            throw new InvalidResourceTypeException(
                ClientTicketFile::class
            );
        }

        /** @var ClientTicketFile $clientTicketFile */
        $clientTicketFile = $this->resource;

        $latestFileVersion = $clientTicketFile->getLatestFileVersion();

        $file = $latestFileVersion->getFile();

        return [
            'id' => $clientTicketFile->getId(),
            'file_versions' => $clientTicketFile->getFileVersions(),
            'ticket_id' => $clientTicketFile->getTicketId(),
            'name' => $file->getOriginalFilename(),
            'folder_id' => $file->getFolder()?->getId(),
            'file_id' => $file->getId(),
            'generated_name' => $file->getFileName(),
            'signed_url' => $file->getUrl(),
            'thumbnail_url' => $file->getThumbnailUrl(),
            'signed_url_expiration' => $file->getUrlExpiration(),
            'directory' => $file->getFilePath(),
            'file_type' => $file->getFileType(),
            'description' => $clientTicketFile->getDescription(),
            'status' => $latestFileVersion->getStatus(),
            'is_approved' => $clientTicketFile->isApproved(),
            'approved_by_id' => $clientTicketFile->getApprovedById(),
            'version' => sprintf('v%s', $file->getVersion()),
            'approved_at' => $clientTicketFile->getApprovedAt(),
            'approved_by' => sprintf(
                '%s %s %s',
                $clientTicketFile->getApprovedBy()?->getFirstName(),
                $clientTicketFile->getApprovedBy()?->getMiddleName(),
                $clientTicketFile->getApprovedBy()?->getLastName(),
            ),
        ];
    }
}
