<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Enum\TicketAssigneeStatusEnum;
use App\Repositories\TicketAssigneeRepository;
use App\Services\Tickets\Resources\UpdateTicketAssigneeResource;
use Tests\TestCase;

/**
 * @covers \App\Repositories\TicketAssigneeRepository
 */
final class TicketAssigneeRepositoryTest extends TestCase
{
    public function testFindByAdminUserAndTicket(): void
    {
        $ticket = $this->env->ticket;

        $adminUser = $this->env->adminUser;

        $ticketAssignee = $this->env->ticketAssignee([
            'ticket_id' => $ticket->getId(),
            'admin_user_id' => $adminUser->getId(),
        ])->ticketAssignee;

        $repository = new TicketAssigneeRepository();

        $result = $repository->findByAdminUserAndTicket($ticket, $adminUser);

        self::assertEquals($ticketAssignee->getId(), $result->getId());
    }

    public function testFindByTicket(): void
    {
        $ticket = $this->env->ticket;

        $ticketAssignee = $this->env->ticketAssignee([
            'ticket_id' => $ticket->getId(),
        ])->ticketAssignee;

        $repository = new TicketAssigneeRepository();

        $result = $repository->findByTicket($ticket);

        $assigneeIds = array_column($result->toArray()['data'], 'id' );

        self::assertContains($ticketAssignee->getId(), $assigneeIds);
    }

    public function testFindWithDepartment(): void
    {
        $ticket = $this->env->ticket;

        $ticketAssignee = $this->env->ticketAssignee([
            'ticket_id' => $ticket->getId(),
        ])->ticketAssignee;

        $repository = new TicketAssigneeRepository();

        $result = $repository->findWithDepartments($ticketAssignee->getId());

        self::assertEquals($ticketAssignee->getId(), $result->getId());
    }

    public function testDeleteByAdminUserAndTicket(): void
    {
        $ticket = $this->env->ticket;

        $adminUser = $this->env->adminUser;

        $ticketAssignee = $this->env->ticketAssignee([
            'ticket_id' => $ticket->getId(),
            'admin_user_id' => $adminUser->getId(),
        ])->ticketAssignee;

        $id = $ticketAssignee->getId();

        $repository = new TicketAssigneeRepository();

        $repository->deleteByAdminUserAndTicket($ticket, $adminUser);

        self::assertNull($repository->find($id));
    }

    public function testDeleteById(): void
    {
        $ticketAssignee = $this->env->ticketAssignee;

        $id = $ticketAssignee->getId();

        $repository = new TicketAssigneeRepository();

        $repository->deleteById($id);

        self::assertNull($repository->find($id));
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testUpdate(): void
    {
        $ticketAssignee = $this->env->ticketAssignee;

        $repository = new TicketAssigneeRepository();

        $ticketAssignee = $repository->update(
            $ticketAssignee,
            new UpdateTicketAssigneeResource([
                'statusEnum' => new TicketAssigneeStatusEnum(TicketAssigneeStatusEnum::COMPLETED)
            ]),
            $this->env->adminUser
        );

        self::assertEquals(TicketAssigneeStatusEnum::COMPLETED, $ticketAssignee->getStatus()->getValue());
    }

}
