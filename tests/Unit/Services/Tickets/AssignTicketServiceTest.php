<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Tickets;

use App\Enum\AdminRoleEnum;
use App\Jobs\Tickets\AssignedTicketSlackNotificationJob;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Services\Tickets\AssignTicketService;
use Exception;
use Tests\Stubs\Repositories\TicketAssigneeRepositoryStub;
use Tests\Stubs\Services\TicketAssigneeLinks\TicketAssigneeLinkResolverStub;
use Tests\TestCase;
use function get_class;

/**
 * @covers \App\Services\Tickets\AssignTicketService
 * @todo Needs to rewrite to use model with no database connection
 * @todo Needs to refactor use only PHPUnit/Testcase
 */
final class AssignTicketServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testAssignSuccess(): void
    {
        $ticket = $this->env->ticket()->ticket;

        $staff = $this->env->adminUser([
            'admin_role' => AdminRoleEnum::STAFF
        ])->adminUser;

        $this->env->user([
            'morphable_type' => \get_class($staff),
            'morphable_id' => $staff->getId(),
        ]);

        $department = $this->env->department()->department;

        $staff->departments()->sync($department);

        $assignee = $this->env->ticketAssignee([
            'admin_user_id' => $staff->getId()
        ])->ticketAssignee;

        $user = $this->env->user([
            'morphable_id' => $staff->getId(),
            'morphable_type' => get_class($staff),
        ])->user;

        $repository = new TicketAssigneeRepositoryStub([
            'assignTicket' => $assignee,
        ]);

        $service = new AssignTicketService(new TicketAssigneeLinkResolverStub(), $repository);

        $service->assign($ticket, $staff, $staff);

        $ticket->refresh();

        $expected = $ticket->getTicketAssignees()->first()->adminUser;

        self::assertEquals($staff->getId(), $expected->getId());
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testAssignThrowException(): void
    {
        $ticket = $this->env->ticket()->ticket;

        $staff = $this->env->adminUser([
            'admin_role' => AdminRoleEnum::STAFF
        ])->adminUser;

        $user = $this->env->user([
            'morphable_id' => $staff->getId(),
            'morphable_type' => get_class($staff),
        ])->user;

        $repository = new TicketAssigneeRepositoryStub([
            'assignTicket' => new Exception(),
        ]);

        $service = new AssignTicketService(new TicketAssigneeLinkResolverStub(), $repository);

        $this->expectException(Exception::class);

        $service->assign($ticket, $staff, $staff);
    }
}
