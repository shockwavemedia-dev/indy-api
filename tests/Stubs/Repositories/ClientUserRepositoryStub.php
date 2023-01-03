<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Repositories\Interfaces\ClientUserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class ClientUserRepositoryStub extends AbstractStub implements ClientUserRepositoryInterface
{
    /**
     * @throws \Tests\Stubs\Repositories\Throwable
     */
    public function create(array $attributes): Model
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
