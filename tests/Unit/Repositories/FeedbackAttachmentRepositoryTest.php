<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Repositories\FeedbackAttachmentRepository;
use Tests\TestCase;

/**
 * @covers \App\Repositories\FeedbackAttachmentRepository
 */
final class FeedbackAttachmentRepositoryTest extends TestCase
{
    public function testDeleteFeedbackAttachment(): void
    {
        $feedbackAttachment = $this->env->fileFeedbackAttachment()->fileFeedbackAttachment;

        $repository = new FeedbackAttachmentRepository();

        $repository->deleteFeedbackAttachment($feedbackAttachment);

        $feedbackAttachment->refresh();

        $this->assertNotNull($feedbackAttachment->getDeletedAt());
    }
}
