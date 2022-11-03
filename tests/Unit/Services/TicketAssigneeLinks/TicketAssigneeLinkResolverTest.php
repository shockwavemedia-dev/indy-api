<?php

declare(strict_types=1);

namespace Tests\Unit\Services\TicketAssigneeLinks;

use App\Enum\TicketAssigneeLinkIssueEnum;
use App\Models\Tickets\TicketAssignee;
use App\Models\Tickets\TicketAssigneeLink;
use App\Models\User;
use App\Services\TicketAssigneeLinks\Resources\CreateTicketAssigneeLinkResource;
use App\Services\TicketAssigneeLinks\TicketAssigneeLinkResolver;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\TicketAssigneeLinkRepositoryStub;
use Tests\Stubs\Services\TicketAssigneeLinks\TicketAssigneeLinkFactoryStub;

/**
 * @covers \App\Services\TicketAssigneeLinks\TicketAssigneeLinkResolver
 */
final class TicketAssigneeLinkResolverTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testResolveSuccess(): void
    {
        $ticketAssigneeLink1 = new TicketAssigneeLink();
        $ticketAssigneeLink2 = new TicketAssigneeLink();

        $user = new User();
        $user->setAttribute('id',1);
        $assignee1 = new TicketAssignee();
        $assignee1->setAttribute('id',1);
        $assignee2 = new TicketAssignee();
        $assignee2->setAttribute('id',1);

        $expectedCall = [
            'factory' => [
                [
                    'make' => [
                        new CreateTicketAssigneeLinkResource([
                            'createdBy' => $user,
                            'linkAssignee' => $assignee2,
                            'mainAssignee' => $assignee1,
                            'linkIssue' => new TicketAssigneeLinkIssueEnum(TicketAssigneeLinkIssueEnum::BLOCKS),
                        ])
                    ],
                ],
                [
                    'make' => [
                        new CreateTicketAssigneeLinkResource([
                            'createdBy' => $user,
                            'linkAssignee' => $assignee1,
                            'mainAssignee' => $assignee2,
                            'linkIssue' => new TicketAssigneeLinkIssueEnum(TicketAssigneeLinkIssueEnum::BLOCKED_BY),
                        ])
                   ],
                ],
            ],
            'repository' => [
                [
                    'findByTwoTicketAssignee' => [
                        $assignee1,
                        $assignee2,
                        new TicketAssigneeLinkIssueEnum(TicketAssigneeLinkIssueEnum::BLOCKS),
                    ],
                ],
            ],
        ];

        $factory = new TicketAssigneeLinkFactoryStub([
            'make' => $ticketAssigneeLink1,
            'make' => $ticketAssigneeLink2,
        ]);

        $repository = new TicketAssigneeLinkRepositoryStub([
            'findByTwoTicketAssignee' => new Collection(),
        ]);

        $resolver = new TicketAssigneeLinkResolver($factory, $repository);
        $resolver->resolve(new CreateTicketAssigneeLinkResource([
            'createdBy' => $user,
            'linkAssignee' => $assignee2,
            'mainAssignee' => $assignee1,
            'linkIssue' => new TicketAssigneeLinkIssueEnum(TicketAssigneeLinkIssueEnum::BLOCKS),
        ]));

        $actualCalls = [
            'repository' => $repository->getCalls(),
            'factory' => $factory->getCalls(),
        ];

        self::assertEquals($expectedCall, $actualCalls);
    }
}
