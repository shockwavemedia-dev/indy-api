<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Repositories\Interfaces\EmailLogRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Tests\Stubs\AbstractStub;

final class EmailLogRepositoryStub extends AbstractStub implements EmailLogRepositoryInterface
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
