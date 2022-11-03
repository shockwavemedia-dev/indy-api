<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\Sms;

use App\Services\SMS\Interfaces\SmsClientInterface;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class SmsClientStub extends AbstractStub implements SmsClientInterface
{
    /**
     * @throws \Throwable
     */
    public function makeRequest(string $method, string $url, ?array $options = null): array
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
