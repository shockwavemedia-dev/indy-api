<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tickets\FileFeedbackAttachment;
use App\Repositories\Interfaces\FileFeedbackAttachmentRepositoryInterface;

final class FeedbackAttachmentRepository extends BaseRepository implements FileFeedbackAttachmentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new FileFeedbackAttachment());
    }

    public function deleteFeedbackAttachment(FileFeedbackAttachment $feedbackAttachment): void
    {
        $feedbackAttachment->delete();
        $feedbackAttachment->save();
    }
}
