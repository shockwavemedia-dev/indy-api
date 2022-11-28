<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enum\UserTypeEnum;
use App\Models\Tickets\FileFeedback;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\Tickets\FileFeedback
 */
final class FileFeedbackTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $expected = [
            'id' => 1,
            'client_file_id' => 1,
            'feedback_by' => 1,
            'feedback_by_type' => UserTypeEnum::ADMIN,
            'feedback' => 'Please remove the background',
        ];

        $fileFeedback = new FileFeedback();
        $fileFeedback->setAttribute('id', 1);
        $fileFeedback->setAttribute('client_file_id', 1);
        $fileFeedback->setAttribute('feedback_by', 1);
        $fileFeedback->setAttribute('feedback_by_type', UserTypeEnum::ADMIN);
        $fileFeedback->setFeedback('Please remove the background');

        $actual = [
            'id' => $fileFeedback->getId(),
            'client_file_id' => $fileFeedback->getClientFileId(),
            'feedback_by' => $fileFeedback->getFeedbackById(),
            'feedback_by_type' => $fileFeedback->getFeedbackByTypeValue(),
            'feedback' => $fileFeedback->getFeedback(),
        ];

        self::assertEquals($expected, $actual);
    }
}
