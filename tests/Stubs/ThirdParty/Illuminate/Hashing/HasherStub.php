<?php

declare(strict_types=1);

namespace Tests\Stubs\ThirdParty\Illuminate\Hashing;

use Illuminate\Contracts\Hashing\Hasher;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class HasherStub extends AbstractStub implements Hasher
{
    /**
     * @throws \Throwable
     */
    public function info($hashedValue): array
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function make($value, array $options = []): string
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function check($value, $hashedValue, array $options = []): bool
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function needsRehash($hashedValue, array $options = []): bool
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
