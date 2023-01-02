<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Repositories\Interfaces\TicketServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketServiceRepositoryStub extends AbstractStub implements TicketServiceRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function create(array $attributes): Model
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
