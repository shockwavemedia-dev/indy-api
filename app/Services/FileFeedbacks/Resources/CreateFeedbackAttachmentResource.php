<?php

declare(strict_types=1);

namespace App\Services\FileFeedbacks\Resources;

use App\Models\File;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\FileFeedback;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateFeedbackAttachmentResource extends DataTransferObject
{
    public ClientTicketFile $clientTicketFile;

    public FileFeedback $fileFeedback;

    public File $file;

    public function getClientTicketFile(): ClientTicketFile
    {
        return $this->clientTicketFile;
    }

    public function getFileFeedback(): FileFeedback
    {
        return $this->fileFeedback;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function setClientTicketFile(ClientTicketFile $clientTicketFile): self
    {
        $this->clientTicketFile = $clientTicketFile;

        return $this;
    }

    public function setFileFeedback(FileFeedback $fileFeedback): self
    {
        $this->fileFeedback = $fileFeedback;

        return $this;
    }

    public function setFile(File $file): self
    {
        $this->file = $file;

        return $this;
    }
}
