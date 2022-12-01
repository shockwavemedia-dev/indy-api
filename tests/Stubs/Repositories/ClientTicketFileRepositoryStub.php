<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class ClientTicketFileRepositoryStub extends AbstractStub implements ClientTicketFileRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function create(array $attributes): ClientTicketFile
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function approve(User $user, ClientTicketFile $clientTicketFile): ClientTicketFile
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function deleteTicketFile(ClientTicketFile $file): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function countNewTicketFile(ClientTicketFile $file): int
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
