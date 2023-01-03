<?php

declare(strict_types=1);

namespace App\Services\FileFeedbacks\Interfaces;

use App\Models\File;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\FileFeedback;
use App\Models\User;
use Illuminate\Http\UploadedFile;

interface ProcessFeedbackAttachmentUploadInterface
{
    public function process(
        File $file,
        User $user,
        FileFeedback $fileFeedback,
        ClientTicketFile $clientTicketFile,
        UploadedFile $uploadedFile
    ): void;
}
