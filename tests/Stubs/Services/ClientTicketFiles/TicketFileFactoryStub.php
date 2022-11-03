<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\ClientTicketFiles;

use App\Models\Tickets\ClientTicketFile;
use App\Services\ClientTicketFiles\Interfaces\TicketFileFactoryInterface;
use App\Services\ClientTicketFiles\Resources\CreateClientTicketFileResource;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketFileFactoryStub extends AbstractStub implements TicketFileFactoryInterface
{
    /**
     * @throws \Throwable
     */
    public function make(CreateClientTicketFileResource $resource): ClientTicketFile
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
