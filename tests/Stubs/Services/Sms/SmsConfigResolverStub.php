<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\Sms;

use App\Services\SMS\Interfaces\SmsConfigResolverInterface;
use App\Services\SMS\Resources\SmsConfigResource;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class SmsConfigResolverStub extends AbstractStub implements SmsConfigResolverInterface
{
    /**
     * @throws \Throwable
     */
    public function resolve(): SmsConfigResource
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
