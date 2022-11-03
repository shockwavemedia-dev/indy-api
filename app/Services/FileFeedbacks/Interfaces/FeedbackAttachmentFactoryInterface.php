<?php

declare(strict_types=1);

namespace App\Services\FileFeedbacks\Interfaces;

use App\Models\Tickets\FileFeedbackAttachment;
use App\Services\FileFeedbacks\Resources\CreateFeedbackAttachmentResource;

interface FeedbackAttachmentFactoryInterface
{
    public function make(CreateFeedbackAttachmentResource $resource): FileFeedbackAttachment;
}
