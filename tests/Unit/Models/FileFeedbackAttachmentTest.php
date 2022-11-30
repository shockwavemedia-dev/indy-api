<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Tickets\FileFeedbackAttachment;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\Tickets\FileFeedbackAttachment
 */
final class FileFeedbackAttachmentTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $expected = [
            'id' => 1,
            'client_file_id' => 1,
            'feedback_id' => 1,
            'file_id' => 1,
        ];

        $attachment = new FileFeedbackAttachment();
        $attachment->setAttribute('id', 1);
        $attachment->setAttribute('client_file_id', 1);
        $attachment->setAttribute('feedback_id', 1);
        $attachment->setAttribute('file_id', 1);

        $actual = [
            'id' => $attachment->getId(),
            'client_file_id' => $attachment->getClientFileId(),
            'feedback_id' => $attachment->getFeedbackId(),
            'file_id' => $attachment->getFileId(),
        ];

        self::assertEquals($expected, $actual);
    }
}
