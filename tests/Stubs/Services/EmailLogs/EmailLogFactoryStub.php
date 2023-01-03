<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\EmailLogs;

use App\Models\Emails\EmailLog;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use Tests\Stubs\AbstractStub;

final class EmailLogFactoryStub extends AbstractStub implements EmailLogFactoryInterface
{
    /**
     * @throws \Throwable
     */
    public function make(CreateEmailLogResource $resource): EmailLog
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
