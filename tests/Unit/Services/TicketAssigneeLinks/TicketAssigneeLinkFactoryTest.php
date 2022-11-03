<?php

declare(strict_types=1);

namespace Tests\Unit\Services\TicketAssigneeLinks;

use App\Enum\TicketAssigneeLinkIssueEnum;
use App\Models\Tickets\TicketAssignee;
use App\Models\Tickets\TicketAssigneeLink;
use App\Models\User;
use App\Services\TicketAssigneeLinks\Resources\CreateTicketAssigneeLinkResource;
use App\Services\TicketAssigneeLinks\TicketAssigneeLinkFactory;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\TicketAssigneeLinkRepositoryStub;

/**
 * @covers \App\Services\TicketAssigneeLinks\TicketAssigneeLinkFactory
 */
final class TicketAssigneeLinkFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testMakeSuccess(): void
    {
        $link = new TicketAssigneeLink();
        $repository = new TicketAssigneeLinkRepositoryStub([
           'create' => $link,
        ]);

        $user = new User();
        $user->setAttribute('id',1);
        $assignee1 = new TicketAssignee();
        $assignee1->setAttribute('id',1);
        $assignee2 = new TicketAssignee();
        $assignee2->setAttribute('id',1);

        $expected = [
            [
                'create' => [
                    [
                        'main_assignee_id' => 1,
                        'link_issue' => TicketAssigneeLinkIssueEnum::BLOCKS,
                        'link_assignee_id' => 1,
                        'created_by' => 1,
                    ],
                ]
            ]
        ];

        $factory = new TicketAssigneeLinkFactory($repository);

        $factory->make(new CreateTicketAssigneeLinkResource([
            'createdBy' => $user,
            'linkAssignee' => $assignee2,
            'mainAssignee' => $assignee1,
            'linkIssue' => new TicketAssigneeLinkIssueEnum(TicketAssigneeLinkIssueEnum::BLOCKS),
        ]));

        self::assertEquals($expected, $repository->getCalls());
    }
}
