<?php

declare(strict_types=1);

namespace App\Services\Tickets\Resources;

use App\Models\Tickets\TicketEvent;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class UploadTicketAttachmentResource extends DataTransferObject
{
    public TicketEvent $ticketEvent;

    public UploadedFile $file;

    public string $filename;

    public ?string $path = '';

    public function getTicketEvent(): TicketEvent
    {
        return $this->ticketEvent;
    }

    public function setTicketEvent(TicketEvent $ticketEvent): self
    {
        $this->ticketEvent = $ticketEvent;

        return $this;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setFile(UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function setPath(?string $path = ''): self
    {
        $this->path = $path;

        return $this;
    }
}
