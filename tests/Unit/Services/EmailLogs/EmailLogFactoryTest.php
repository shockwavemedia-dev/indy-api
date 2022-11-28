<?php

declare(strict_types=1);

namespace Tests\Unit\Services\EmailLogs;

use App\Enum\EmailStatusEnum;
use App\Models\Emails\EmailLog;
use App\Models\Tickets\TicketAssignee;
use App\Services\EmailLogs\EmailLogFactory;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use PHPUnit\Framework\TestCase;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Tests\Stubs\Repositories\EmailLogRepositoryStub;

/**
 * @covers \App\Services\EmailLogs\EmailLogFactory
 */
final class EmailLogFactoryTest extends TestCase
{
    /**
     * @throws UnknownProperties
     */
    public function testMakeSuccess(): void
    {
        $ticketAssignee = new TicketAssignee();
        $ticketAssignee->setAttribute('id', 1);

        $emailLog = new EmailLog();

        $repository = new EmailLogRepositoryStub([
            'create' => $emailLog,
        ]);

        $expectedCall = [
            [
                'create' => [
                    [
                        'status' => EmailStatusEnum::SENT,
                        'failed_details' => 'test',
                        'morphable_id' => 1,
                        'morphable_type' => 'App\Models\Tickets\TicketAssignee',
                        'cc' => 'test',
                        'to' => 'test',
                        'message' => 'test',
                    ],
                ],
            ],
        ];

        $factory = new EmailLogFactory($repository);
        $factory->make(new CreateEmailLogResource([
            'failedDetails' => 'test',
            'status' => new EmailStatusEnum(EmailStatusEnum::SENT),
            'emailType' => $ticketAssignee,
            'cc' => 'test',
            'to' => 'test',
            'message' => 'test',
        ]));

        self::assertEquals($expectedCall, $repository->getCalls());
    }
}
