<?php

declare(strict_types=1);

namespace App\Services\ClientTicketFiles\Interfaces;

use App\Models\File;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\ClientTicketFiles\Exceptions\FileAlreadyExistException;
use App\Services\ClientTicketFiles\Exceptions\ReplaceFileNotAllowedException;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface ProcessTicketFileUploadInterface
{
    /**
     * @throws FileAlreadyExistException
     * @throws UnknownProperties
     */
    public function process(
        File $file,
        User $user,
        Ticket $ticket,
        UploadedFile $uploadedFile
    ): ClientTicketFile;
}
