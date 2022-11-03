<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Tickets\FileFeedbackAttachment;

interface FileFeedbackAttachmentRepositoryInterface
{

    public function deleteFeedbackAttachment(FileFeedbackAttachment $feedbackAttachment): void;

}
