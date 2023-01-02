<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Models\Tickets\FileFeedbackAttachment;
use App\Repositories\Interfaces\FileFeedbackAttachmentRepositoryInterface;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class FeedbackAttachmentRepositoryStub extends AbstractStub implements FileFeedbackAttachmentRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function deleteFeedbackAttachment(FileFeedbackAttachment $feedbackAttachment): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }
}
