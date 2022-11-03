<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Enum\TicketFileStatusEnum;
use App\Repositories\ClientTicketFileRepository;
use Tests\TestCase;

/**
 * @covers \App\Repositories\ClientTicketFileRepository
 */
final class ClientTicketFileRepositoryTest extends TestCase
{
    public function testApprove(): void
    {
        $userType = $this->env->clientUser;

        $user = $this->env->user([
            'morphable_id' => $userType->getId(),
            'morphable_type' => \get_class($userType),
        ])->user;

        $clientTicketFile = $this->env->clientTicketFile([
            'approved_by' => $user->getId(),
        ])->clientTicketFile;

        $repository = new ClientTicketFileRepository();

        $approved = new TicketFileStatusEnum(TicketFileStatusEnum::APPROVED);

        $clientTicketFile = $repository->approve($user, $clientTicketFile);

        self::assertEquals($approved, $clientTicketFile->getStatus());
        self::assertEquals($user->getId(), $clientTicketFile->getApprovedById());
    }

    public function testDeleteTicketFile(): void
    {
        $clientTicketFile = $this->env->clientTicketFile()->clientTicketFile;

        $repository = new ClientTicketFileRepository();

        $repository->deleteTicketFile($clientTicketFile);

        $clientTicketFile->refresh();

        $this->assertEquals(TicketFileStatusEnum::DELETED, $clientTicketFile->getStatus()->getValue());
    }
}
