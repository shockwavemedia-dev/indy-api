<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Repositories\Interfaces\LeadClientRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class LeadClientRepositoryStub extends AbstractStub implements LeadClientRepositoryInterface
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
