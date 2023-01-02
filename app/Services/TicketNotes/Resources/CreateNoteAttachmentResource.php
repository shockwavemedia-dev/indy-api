<?php

declare(strict_types=1);

namespace App\Services\TicketNotes\Resources;

use App\Models\File;
use App\Models\Tickets\TicketNote;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateNoteAttachmentResource extends DataTransferObject
{
    public User $createdBy;

    public TicketNote $ticketNote;

    public File $file;

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @return TicketNote
     */
    public function getTicketNote(): TicketNote
    {
        return $this->ticketNote;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }
}
