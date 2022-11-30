<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Enum\TicketStatusEnum;
use App\Enum\TicketTypeEnum;
use App\Repositories\TicketRepository;
use App\Services\Tickets\Resources\TicketFilterOptionsResource;
use App\Services\Tickets\Resources\UpdateTicketResource;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * @covers \App\Repositories\TicketRepository
 */
final class TicketSupportRepositoryTest extends TestCase
{
    public function testCountTicketByClient(): void
    {
        $client = $this->env->client()->client;

        $ticket = $this->env->ticket(
            [
                'client_id' => $client->getId(),
            ]
        )->ticket;

        $repository = new TicketRepository();

        $countTicketByClient = $repository->countTicketByClient($client);

        $ticket->refresh();

        $this->assertEquals(1, $countTicketByClient);
    }

    public function testDeleteTicketSupport(): void
    {
        $ticket = $this->env->ticket()->ticket;

        $user = $this->env->user;

        $repository = new TicketRepository();

        $repository->deleteTicketSupport($ticket, $user);

        $ticket->refresh();

        $this->assertEquals(TicketStatusEnum::DELETED, $ticket->getStatus()->getValue());
    }

    public function testFindByClient(): void
    {
        $client = $this->env->client()->client;

        $ticket = $this->env->ticket(
            [
                'client_id' => $client->getId(),
            ]
        )->ticket;

        $repository = new TicketRepository();

        $findByClient = $repository->findByClient($client, new TicketFilterOptionsResource());

        $ticket->refresh();

        $this->assertEquals(1, $findByClient->count());
    }

    public function testByDepartment(): void
    {
        $department = $this->env->department;

        $ticket1 = $this->env->ticket([
            'department_id' => $department->getId(),
        ])->ticket;

        $ticket2 = $this->env->ticket()->ticket;

        $this->env->ticketAssignee([
            'department_id' => $department,
            'ticket_id' => $ticket2->getId(),
        ]);

        $repository = new TicketRepository();

        $result = $repository->findByDepartment($department);

        self::assertNotNull($result->find($ticket1->getId()));
        self::assertNotNull($result->find($ticket2->getId()));
    }

    public function testFindSupportTickets(): void
    {
        $ticket = $this->env->ticket()->ticket;

        $repository = new TicketRepository();

        $findSupportTickets = $repository->findSupportTickets();

        $find = $findSupportTickets->find($ticket->getId());

        self::assertNotNull($find);
    }

    public function testFindByOptions(): void
    {
        $ticket = $this->env->ticket;

        $repository = new TicketRepository();

        $options = [
            'status' => [TicketStatusEnum::NEW],
            'types' => [TicketTypeEnum::EMAIL],
            'department_ids' => [$ticket->getDepartmentId()],
        ];

        $findSupportTickets = $repository->findByOptions($options);

        $find = $findSupportTickets->find($ticket->getId());

        self::assertNotNull($find);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testUpdateTicketSuccess(): void
    {
        $user = $this->env->user()->user;

        $ticket = $this->env->ticket(
            [
                'created_by' => $user->getId(),
                'requested_by' => $user->getId(),
                'created_by_user_type' => $user->getUserType()->getType()->getValue(),
            ]
        )->ticket;

        $updateResource = new UpdateTicketResource([
            'subject' => 'Test Ticket',
            'description' => '{}',
            'type' => (new TicketTypeEnum(TicketTypeEnum::EMAIL)),
            'updatedBy' => $user,
            'dueDate' => new Carbon('03/01/2023'),
            'status' => (new TicketStatusEnum(TicketStatusEnum::OPEN)),
        ]);

        $repository = new TicketRepository();

        $expected = [
            'subject' => 'Test Ticket',
            'description' => '{}',
            'type' => (new TicketTypeEnum(TicketTypeEnum::EMAIL)),
            'updatedBy' => $user->getId(),
            'dueDate' => new Carbon('03/01/2023'),
            'status' => (new TicketStatusEnum(TicketStatusEnum::OPEN)),

        ];

        $ticket = $repository->update($ticket, $updateResource);

        $ticket->refresh();

        $actual = [
            'subject' => $ticket->getSubject(),
            'description' => $ticket->getDescription(),
            'type' => $ticket->getType(),
            'updatedBy' => $ticket->getUpdatedById(),
            'dueDate' => $ticket->getDueDate(),
            'status' => $ticket->getStatus(),
        ];

        self::assertEquals($expected, $actual);
    }

    public function testFindByOptionsSortedSuccess(): void
    {
        $ticket1 = $this->env->ticket;
        $ticket2 = $this->env->ticket;

        $repository = new TicketRepository();

        $options = [
            'status' => [TicketStatusEnum::NEW],
            'types' => [TicketTypeEnum::EMAIL],
        ];

        $findSupportTickets = $repository->findByOptions($options);

        self::assertEquals($ticket2->getId(), $findSupportTickets->first()->getId());
    }

    public function testFindMyTicket(): void
    {
        $ticket = $this->env->ticket;

        $repository = new TicketRepository();

        $adminUser = $this->env->adminUser;

        $this->env->ticketAssignee([
            'ticket_id' => $ticket->getId(),
            'admin_user_id' => $adminUser->getId(),
        ])->ticketAssignee;

        $findMyTickets = $repository->findByAssigneeAdminUser($adminUser);

        $this->assertNotNull($findMyTickets);

        self::assertEquals($ticket->getId(), $findMyTickets->first()->getId());
    }
}
