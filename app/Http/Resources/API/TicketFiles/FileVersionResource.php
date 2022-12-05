<?php

declare(strict_types=1);

namespace App\Http\Resources\API\TicketFiles;

use App\Http\Resources\Resource;
use App\Models\TicketFileVersion;

final class FileVersionResource extends Resource
{
    protected function getResponse(): array
    {
        /** @var TicketFileVersion $fileVersion */
        $fileVersion = $this->resource;

        $ticketFile = $fileVersion->getTicketFile();

        $approver = $ticketFile->getApprovedBy();

        $isLatest = $ticketFile->getLatestFileVersion()->getId() === $fileVersion->getId();

        return [
            'id' => $fileVersion->getId(),
            'ticket_file_id' => $ticketFile->getId(),
            'file_version' => $fileVersion->getVersion(),
            'ticket_id' => $ticketFile->getTicketId(),
            'name' => $fileVersion->getFile()->getOriginalFilename(),
            'folder_id' => $fileVersion->getFile()->getFolder()?->getId(),
            'file_id' => $fileVersion->getFile()->getId(),
            'generated_name' => $fileVersion->getFile()->getFileName(),
            'signed_url' => $fileVersion->getFile()->getUrl(),
            'thumbnail_url' => $fileVersion->getFile()->getThumbnailUrl(),
            'signed_url_expiration' => $fileVersion->getFile()->getUrlExpiration(),
            'directory' => $fileVersion->getFile()->getFilePath(),
            'file_type' => $fileVersion->getFile()->getFileType(),
            'description' => $ticketFile->getDescription(),
            'status' => $fileVersion->getAttribute('status'),
            'is_latest' => $isLatest,
            'approved_by_id' => $ticketFile->getApprovedById(),
            'version' => sprintf('v%s', $fileVersion->getVersion()),
            'approved_at' => $ticketFile->getApprovedAt(),
            'approved_by' => sprintf(
                '%s %s %s',
                $approver?->getFirstName(),
                $approver?->getMiddleName(),
                $approver?->getLastName(),
            ),
        ];
    }
}
