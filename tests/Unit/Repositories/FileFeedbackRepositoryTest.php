<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Repositories\FileFeedbackRepository;
use App\Services\FileFeedbacks\Resources\UpdateFileFeedbackResource;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Tests\TestCase;

/**
 * @covers \App\Repositories\FileFeedbackRepository
 */
final class FileFeedbackRepositoryTest extends TestCase
{
    public function testFindByClientTicketFile(): void
    {
        $clientTicketFile = $this->env->clientTicketFile()->clientTicketFile;

        $this->env->fileFeedback(
            [
                'client_file_id' => $clientTicketFile->getId(),
            ]
        )->fileFeedback;

        $repository = new FileFeedbackRepository();

        $findByClientTicketFile = $repository->findByClientTicketFile($clientTicketFile);

        $this->assertEquals(1, $findByClientTicketFile->count());
    }

    /**
     * @throws UnknownProperties
     */
    public function testUpdateFeedbackSuccess(): void
    {
        $fileFeedback = $this->env->fileFeedback()->fileFeedback;

        $updateResource = new UpdateFileFeedbackResource([
            'feedback' => 'Please change the color to #fffff',
        ]);

        $repository = new FileFeedbackRepository();

        $expected = [
            'feedback' => 'Please change the color to #fffff',
        ];

        $ticket = $repository->update($fileFeedback, $updateResource);

        $ticket->refresh();

        $actual = [
            'feedback' => $ticket->getFeedback(),
        ];

        self::assertEquals($expected, $actual);
    }

    public function testDeleteFileFeedback(): void
    {
        $fileFeedback = $this->env->fileFeedback()->fileFeedback;

        $repository = new FileFeedbackRepository();

        $repository->deleteFileFeedback($fileFeedback);

        $fileFeedback->refresh();

        $this->assertNotNull($fileFeedback->getDeletedAt());
    }
}
