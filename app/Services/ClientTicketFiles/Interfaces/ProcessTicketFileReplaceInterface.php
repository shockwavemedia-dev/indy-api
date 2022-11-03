<?php

declare(strict_types=1);

namespace App\Services\ClientTicketFiles\Interfaces;

use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use App\Services\ClientTicketFiles\Exceptions\FileNotExistException;
use App\Services\ClientTicketFiles\Exceptions\ReplaceFileNotAllowedException;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface ProcessTicketFileReplaceInterface
{
    /**
     * @throws UnknownProperties
     * @throws ReplaceFileNotAllowedException
     * @throws FileNotExistException
     */
    public function replace(
        User $user,
        ClientTicketFile $clientTicketFile,
        UploadedFile $uploadedFile,
        string $filepath
    ): ClientTicketFile;
}
